<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Trang chủ', route('dashboard'));
});
// Student
Breadcrumbs::for('admin/students', function ($trail) {
    $trail->push('Học viên', route('students'));
});
// Teacher
Breadcrumbs::for('admin/teachers', function ($trail) {
    $trail->push('Giảng viên', route('teacher.index'));
});
// Class
Breadcrumbs::for('admin/class', function ($trail) {
    $trail->push('Lớp học', route('class.index'));
});
// Course
Breadcrumbs::for('admin/courses', function ($trail) {
    $trail->push('Khóa học', route('course.index'));
});
// Unit
Breadcrumbs::for('admin/units', function ($trail, $unit) {
    $trail->parent('admin/courses');
    if($unit->id)
        $trail->push($unit->title, route('unit.detail', $unit->id));
});
// Lesson
Breadcrumbs::for('admin/lessons', function ($trail, $lesson) {
    if($lesson->id) {
        $trail->parent('admin/units', $lesson->unit);
        $trail->push($lesson->title, route('lesson.detail', $lesson->id));
    } else
        $trail->parent('admin/courses');
});
// Question
Breadcrumbs::for('admin/questions', function ($trail) {
    $trail->push('Ngân hàng câu hỏi', route('question.index'));
});
// Test
Breadcrumbs::for('admin/test', function ($trail) {
    $trail->push('Bài test', route('test.index'));
});
// Score
Breadcrumbs::for('admin/score', function ($trail) {
    $trail->push('Điểm bài test', route('score.index'));
});
// User
Breadcrumbs::for('admin/users', function ($trail) {
    $trail->push('Uers', route('users.index'));
});
// Role
Breadcrumbs::for('admin/roles', function ($trail) {
    $trail->push('Roles', route('roles.index'));
});