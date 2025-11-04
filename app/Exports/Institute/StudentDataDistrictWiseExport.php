<?php 

namespace App\Exports\Institute;

use App\Models\Student;
use App\Models\College;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentDataDistrictWiseExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $instituteMember = Auth::guard('institute')->user();
        $college_detail = College::find($instituteMember->college_id);
        $city_id = $college_detail->city; 
        $students = Student::where('city', $city_id)->get();
        $data = [];
        $i = 1;

        foreach($students as $student){
            if($student->course == 1){
                $course_name = 'UPSC';
            }elseif($student->course == 2){
                $course_name = 'SSC';
            }else{
                $course_name = 'N/A';
            }
            $data[] = [
                'SL'           => $i++,
                'Student Name' => $student->name,
                'Email'        => $student->email,
                'Mobile No'    => $student->mobile ,
                'Course'       => $course_name,
                'State'        => $student->stateName->name,  
                'City'         => $student->cityName->name,  
                'Address'      => $student->address ?? 'N/A',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'SL',
            'Student Name',
            'Email',
            'Mobile No',
            'Course',
            'State',
            'City',
            'Address'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Optional: For bold heading
            1 => ['font' => ['bold' => true]],
        ];
    }
}
