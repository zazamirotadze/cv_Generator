<?php
namespace zazaCv;
class SomeLogic {
    const patternsToReplace = [
        "{{ name }}", 
        "{{ surname }}", 
        "{{ date }}", 
        "{{ relationship }}", 
        "{{ address }}", 
        "{{ phone }}", 
        "{{ email }}", 
        "{{ languages }}", 
        "{{ education }}", 
        "{{ computer_skills }}", 
        "{{ accounts }}", 
        "{{ work_experience }}", 
        "{{ photo }}"
    ];
    const possibleRelValues = ["married","single","widow","divorced"];
    const mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const phonePattern = '/^\+?(\d{3})?(\d{9})$/';
    const emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    public static function dateFormatter($date):string{
        $d = explode('-', $date);
        $year = intval($d[0]);
        $month = intval($d[1]);
        $day = intval($d[2]);
        return "{$day}.{$month}.{$year}";
    }
}
