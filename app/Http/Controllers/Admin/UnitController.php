<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function showUnit($slug) {
        $unit = Unit::where('slug', $slug)
        ->first();

        $lessons = Lesson::select([
            'lessons.id',
            'lessons.title',
            'lessons.slug',
            'lessons.config',
            'lessons.created_at',
            'lessons.updated_at',
        ])
        ->join('units', 'lessons.unit_id', 'units.id')
        ->where('units.slug', $slug)
        ->orderBy('id', 'desc')
        ->paginate();

        return view('admin.modules.courses.units.detail', compact('unit','lessons'));
    }
}
