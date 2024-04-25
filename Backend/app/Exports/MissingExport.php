<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MissingExport implements FromView, ShouldAutoSize, WithTitle
{
    /**
    * @return Illuminate\Contracts\View\View;
    */

	protected $passengers;

	function __construct($passengers){
		$this->passengers = $passengers;
	}
	
	public function view() : View
    {
        return view("exports.missing", [
			'passengers' => $this->passengers,
		]);
    }

	public function title() : string
	{
		return 'Missing List';
	}

	
}
