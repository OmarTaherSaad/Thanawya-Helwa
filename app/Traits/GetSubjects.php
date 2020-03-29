<?php
namespace App\Traits;
/**
 * Get Subjects
 */
trait GetSubjects
{
    public function getSubjects()
    {
        $subjects = collect();
        try {
            $subjects = file_get_contents(storage_path('app/subjects.json'));
        } catch (\Throwable $th) {
        }
        return collect(json_decode($subjects))->unique()->sort();
    }
}
