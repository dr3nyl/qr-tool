<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreQrRequest;
use App\Models\QrDetail;
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
            'qr_code' => $this->part_number.'-'.$this->date_code.'-'.$this->vendor_code,
            'created_by' => auth()->user()->name
        ]);
    }

    public function rules()
    {
        $this->qr_code = $this->part_number.'-'.$this->date_code.'-'.$this->vendor_code;

        return [
            'qr_code' => 'required|min:6'
        ];
    }

    public function render()
    {
        return view('livewire.qr-creation-form');
    }
}
