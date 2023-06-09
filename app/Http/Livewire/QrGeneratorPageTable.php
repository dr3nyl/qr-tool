<?php

namespace App\Http\Livewire;

use App\Models\QrDetail;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;


final class QrGeneratorPageTable extends PowerGridComponent
{
    use ActionButton;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'bulkPrintPdf',
                'bulkDownloadQR',
                'bulkDeleteQR',
                'deleteQR',
                'deleteQR_confirm',
                'deleteQR_confirm_single'
            ]);
    }

    public function header(): array
    {
        return [
            Button::add('bulk-print-pdf')
                ->caption(__('Print Selected'))
                ->class('cursor-pointer block bg-indigo-500 text-white underline')
                ->emit('bulkPrintPdf', []),
            Button::add('bulk-download')
                ->caption(__('Download Selected'))
                ->class('cursor-pointer block bg-indigo-500 text-white underline')
                ->emit('bulkDownloadQR', []),
            Button::add('bulk-delete')
                ->caption(__('Deleted Selected'))
                ->class('cursor-pointer block bg-indigo-500 text-red underline')
                ->emit('bulkDeleteQR', [])
        ];
    }

    public function deleteQR_confirm_single($qr_details){
        $this->dispatchBrowserEvent('confirm-delete', [$qr_details]);
        return;
    }

    public function deleteQR_confirm($qr_details){
        $this->dispatchBrowserEvent('confirm-delete', $qr_details);
        return;
    }
    public function deleteQR($qr_details){
        //DELETE
        $qr_ids = array_column($qr_details, 'qr_id');
        // dd($qr_details);
        // QrDetail::whereIn('id', $qr_ids)->update(array('is_deleted' => 1));
        QrDetail::destroy($qr_ids);
        activity_log('DELETEQR', implode(', ', array_column($qr_details, 'qr_name')));
        return;
    }

    public function bulkDeleteQR(){
        $qrcodes = [];

        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);
            return;
        }

        $result = QrDetail::whereIn('id', $this->checkboxValues)->pluck('qr_code','id');
        foreach ($result as $key => $value) {
            $qrcodes[] = ['qr_id' => $key, 'qr_name' => $value];
        }

        $this->deleteQR_confirm($qrcodes);
        
        return ;
    }

    public function bulkDownloadQR(){
        $qrcodes = [];

        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);
            return;
        }

        $result = QrDetail::whereIn('id', $this->checkboxValues)->pluck('qr_code');
        
        for ($i=0; $i < count($result); $i++) { 
            $qrcode = QrCode::format('png')->size(200)->margin(1)->errorCorrection('H')->generate($result[$i])->toHtml();
            $qrcodes[] = ['name' => replace_special_chars__($result[$i]), 'qrcode' => $qrcode];
        }


        activity_log('DOWNLOADQR', implode(', ', array_column($qrcodes, 'name')));

        $zip = new ZipArchive;
        $fileName = 'QR_Codes.zip';
        if ($zip->open(public_path($fileName), (ZipArchive::CREATE | ZipArchive::OVERWRITE)) === TRUE)
        {
            foreach ($qrcodes as $key => $value) {
                $relativeNameInZipFile = $value['name'].'.png';
                $zip->addFromString($relativeNameInZipFile,$value['qrcode']);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }

    public function bulkPrintPdf()
    {
        $qrcodes = [];

        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);

            return;
        }

        $result = QrDetail::whereIn('id', $this->checkboxValues)->pluck('qr_code');
        
        for ($i=0; $i < count($result); $i++) { 
            $qrcode = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate($result[$i]));
            $qrcodes[] = ['name' => $result[$i], 'qrcode' => $qrcode];
        }

        activity_log('PRINTQR', implode(', ', array_column($qrcodes, 'name')));

        $pdfContent = FacadePdf::loadView('admin.qr.download.pdf-qrcode', ['data' => $qrcodes])->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\QrDetail>
    */
    public function datasource(): Builder
    {
        return QrDetail::query()->where('is_deleted', 0)->orderBy('id', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            // ->addColumn('id')
            ->addColumn('part_number')

           /** Example of custom column using a closure **/
            ->addColumn('part_number_lower', function (QrDetail $model) {
                return strtolower(e($model->part_number));
            })

            ->addColumn('date_code')
            ->addColumn('vendor_code')
            ->addColumn('qr_code')
            ->addColumn('created_by')
            ->addColumn('created_at_formatted', fn (QrDetail $model) => Carbon::parse($model->created_at)->format('F j, Y h:i:s A'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            // Column::make('ID', 'id'),

            // Column::make('PART NUMBER', 'part_number')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('DATE CODE', 'date_code')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('VENDOR CODE', 'vendor_code')
            //     ->sortable()
            //     ->searchable(),

            Column::make('QR CODE', 'qr_code')
                ->sortable()
                ->searchable(),

            Column::make('CREATED BY', 'created_by')
                ->sortable()
                ->searchable(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at', ['enableTime' => true]),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid QrDetail Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
           Button::make('download', '
  <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/><title>Download</title></svg>
')
               ->class('bg-gray-300 dark:bg-gray-300 hover:bg-gray-400 font-bold rounded inline-flex items-center bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('qrcode.download', ['data' => 'id']),

           Button::make('destroy', 'DELETE')
               ->class('cursor-pointer text-red-800 dark:text-red-800 px-3 py-2.5 m-1 rounded text-sm')
               //->route('qr-detail.destroy', ['qr-detail' => 'id'])
               // ->method('delete')
               ->emit('deleteQR_confirm_single', ['qr_id' => 'id', 'qr_name' => 'qr_code'])
        ];
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid QrDetail Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($qr-detail) => $qr-detail->id === 1)
                ->hide(),
        ];
    }
    */
}
