<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreQrRequest;
use App\Models\QrDetail;
use Carbon\Carbon;
use Livewire\Component;

class QrCreationForm extends Component
{

    public $part_number;
    public $date_code;
    public $vendor_code;
    public $qr_code;

    public function submitForm()
    {
        $this->validate();

        $this->emitTo(QrGeneratorPageTable::class, 'pg:eventRefresh-default');

        QrDetail::create([
            'part_number' => $this->part_number,
            'date_code' => $this->date_code,
            'vendor_code' => $this->vendor_code,
            'qr_code' => $this->part_number.' '.$this->date_code.' '.$this->vendor_code,
            'created_by' => auth()->user()->name,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public function rules()
    {
        $this->qr_code = $this->part_number.' '.$this->date_code.' '.$this->vendor_code;

        return [
            'part_number' => 'required',
            'date_code' => 'required',
            'vendor_code' => 'required',
            'qr_code' => 'required|unique:qr_details,qr_code'
        ];
    }

    public function render()
    {
        return view('livewire.qr-creation-form');
    }
}
