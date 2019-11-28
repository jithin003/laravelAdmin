<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function attendence()
    {
        return $this->hasMany('App\StudentAttendance');
    }
    
    public function medicalDetails()
    {
        return $this->hasOne('App\StudentMedicalInfo');
    }

    public function getFirstNameAttribute($valus)
    {
        return ucwords($valus);
    }

    /* public function exams()
    {
    $results = $this->results;
    $exams = [];
    foreach ($results as $result) {
    $exams[] = $result->exam;
    }
    return $exams;
    }

    public function examCategories()
    {
    $exams = $this->exams();
    $categories = [];
    foreach ($exams as $exam) {
    $category['category_id'] = $exam->exam_category_id;
    $category['category_name'] = $exam->category->name;
    $category['exam_id'] = $exam->id;
    $categories[] = $category;
    }
    $cat = array_unique(array_column($categories, 'category_id'));
    return array_intersect_key($categories, $cat);
    } */

    /**
     * This method is used to generate the student ID
     * @param  [type] $userid [description]
     * @return [type]         [description]
     */
    public function prepareStudentID($userid)
    {
        $settings = new GeneralSettings();

        $count = $this->getStudentCount();

        $length = $settings->getAdmissionNoLength();
        $user_id = $userid . $length;

        if (strlen($count) < $length) {
            $user_id = $userid . makeNumber($count, $length);
        }

        return $settings->getStudentIDPrefix() . $userid;
    }

    public function prepareRollNo($userid, $academic_id, $course_parent_id, $course_id, $current_year, $current_semister)
    {
        $studentSettings = new StudentSettings();
        $settings = (object)$studentSettings->getSettings();
        $length = $settings->roll_no_length;
        $academic_record = Academic::where('id', '=', $academic_id)->first();
        $course_parent_record = Course::where('id', '=', $course_parent_id)->first();
        $course_record = Course::where('id', '=', $course_id)->first();

        $year = date('y', strtotime($academic_record->academic_start_date));

        $parent_course_code = $course_parent_record->course_code;

        $course_code = $course_record->course_code;
        $serial_no = makeNumber($this->getStudentSerialNo($academic_id, $course_parent_id, $course_id, $current_year, $current_semister, $length) + 1, $length);

        $roll_no = $year . $parent_course_code . $course_code . $serial_no;
        return $roll_no;

    }

    public function getStudentCount()
    {
        return Student::all()->count();
    }

    public function getStudentSerialNo($academic_id, $course_parent_id, $course_id, $current_year, $current_semister, $length = 4)
    {
        $record = DB::table('students')->select([DB::raw('max(RIGHT(roll_no,' . $length . ')) as roll_no')])
            ->where('academic_id', '=', $academic_id)
            ->where('course_parent_id', '=', $course_parent_id)
            ->where('course_id', '=', $course_id)
            ->first();
        $count = 0;
        if (isset($record->roll_no)) {
            if ($record->roll_no) {
                $count = (int)$record->roll_no;
            }

        }

        return $count;

    }

    /**
     * this method returns the student list it is not necessary course_parent_id
     */

    public function getStudents($academic_id, $course_id, $year, $semester)
    {
        return Student::where('academic_id', '=', $academic_id)
            ->where('course_id', '=', $course_id)
            ->where('current_year', '=', $year)
            ->where('current_semister', '=', $semester)
            ->get();
    }

    public function getStudentslist($academic_id, $course_parent_id, $course_id, $year, $semister)
    {
        return Student::where('academic_id', '=', $academic_id)
            ->where('course_parent_id', '=', $course_parent_id)
            ->where('course_id', '=', $course_id)
            ->where('current_year', '=', $year)
            ->where('current_semister', '=', $semister)
            ->get();
    }

    public function getStudentRecordWithRollNo($roll_no)
    {
        return Student::where('roll_no', '=', $roll_no)->first();
    }
}
