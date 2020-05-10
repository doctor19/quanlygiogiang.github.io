<?php

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.dashboard.title'), route('dashboard'));
});
// Breadcrumbs::register('test', function ($breadcrumbs) {
//     $breadcrumbs->parent('dashboard');
//     $breadcrumbs->push('Test', route('test'));
// });
Breadcrumbs::register('mst_users.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.users.title'), route('mst_users.index'));
});
Breadcrumbs::register('mst_users.add', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_users.index');
    $breadcrumbs->push(trans('labels.backend.users.add'), route('mst_users.add'));
});
Breadcrumbs::register('mst_users.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_users.index');
    $breadcrumbs->push(trans('labels.backend.users.edit'), route('mst_users.edit'));
});
Breadcrumbs::register('mst_users.changepass', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_users.index');
    $breadcrumbs->push(trans('labels.backend.users.changepass'), route('mst_users.changepass'));
});
Breadcrumbs::register('mst_users.change_info', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_users.index');
    $breadcrumbs->push(trans('labels.backend.users.changeinfo'), route('mst_users.change_info'));
});

Breadcrumbs::register('mst_unit.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_unit.title'), route('mst_unit.index'));
});


Breadcrumbs::register('mst_mission.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_mission.title'), route('mst_mission.index'));
});
Breadcrumbs::register('mst_mission.add', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_mission.index');
    $breadcrumbs->push(trans('labels.backend.mst_mission.add'), route('mst_mission.add'));
});
Breadcrumbs::register('mst_mission.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('mst_mission.index');
    $breadcrumbs->push(trans('labels.backend.mst_mission.edit'), route('mst_mission.edit'));
});

Breadcrumbs::register('mst_position.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_position.title'), route('mst_position.index'));
});

Breadcrumbs::register('mst_title.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_title.title'), route('mst_title.index'));
});

Breadcrumbs::register('mst_class.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_class.title'), route('mst_class.index'));
});

Breadcrumbs::register('mst_semester.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_semester.title'), route('mst_semester.index'));
});

Breadcrumbs::register('mst_term.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('labels.backend.mst_term.title'), route('mst_term.index'));
});

// require __DIR__.'/Search.php';
// require __DIR__.'/Access.php';
// require __DIR__.'/LogViewer.php';
