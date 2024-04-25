<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ManifestExport implements FromView, ShouldAutoSize, WithTitle, WithDrawings
{
    /**
    * @return Illuminate\Contracts\View\View;
    */

	protected $flight;

	function __construct($flight){
		$this->flight = $flight;
	}
	
	public function view() : View
    {
        return view("exports.manifest", [
			'flight' => $this->flight,
		]);
    }

	public function title() : string
	{
		return 'Items';
	}

	public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Kish Air Log');
        $drawing->setDescription('Kish Air Log');
        $drawing->setPath(public_path('/assets/logo.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
