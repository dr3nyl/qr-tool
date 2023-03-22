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
                'bulkSoldOutEvent',
                'bulkDownloadQR'
            ]);
    }

    public function header(): array
    {
        return [
            Button::add('bulk-sold-out')
                ->caption(__('Print Selected'))
                ->class('cursor-pointer block bg-indigo-500 text-white underline')
                ->emit('bulkSoldOutEvent', []),
            Button::add('bulk-download')
                ->caption(__('Download Selected'))
                ->class('cursor-pointer block bg-indigo-500 text-white underline')
                ->emit('bulkDownloadQR', [])
        ];
    }

    public function bulkDownloadQR(){
        $qrcodes = [];

        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);
            return;
        }

        $result = QrDetail::whereIn('id', $this->checkboxValues)->pluck('qr_code');
        
        for ($i=0; $i < count($result); $i++) { 
            $qrcode = QrCode::format('png')->size(200)->generate($result[$i])->toHtml();
            $qrcodes[] = ['name' => $result[$i], 'qrcode' => $qrcode];
        }

        $zip = new ZipArchive;
        $fileName = 'QR_Codes.zip';
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            foreach ($qrcodes as $key => $value) {
                $relativeNameInZipFile = $value['name'].'.png';
                $zip->addFromString($relativeNameInZipFile,$value['qrcode']);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }

    public function bulkSoldOutEvent()
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
        return QrDetail::query()->orderBy('id', 'desc');
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
            ->addColumn('created_at_formatted', fn (QrDetail $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
                ->makeInputDatePicker(),

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
               ->route('qrcode.download', ['data' => 'qr_code']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        //->route('qr-detail.destroy', ['qr-detail' => 'id'])
        //        ->method('delete')
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
