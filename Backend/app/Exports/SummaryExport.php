<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SummaryExport implements FromView, ShouldAutoSize, WithTitle
{
	protected $flight;

	function __construct($flight) {
		$this->flight = $flight;
	}

    public function view() : View
    {
        return view("exports.summary", [
			'flight' => $this->flight,
		]);
    }

	public function title() : string
	{
		return 'Flight Summary';
	}
}
