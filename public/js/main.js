function ReloadConversatorEvents()
{
    $('#eventsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/conservator/ajaxevents',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'departmentId': $("#department").val(), 'sorts': $("#sort").val(), 'confirm': $("#confirm").val() , 'confirm_dep': $("#confirm_dep").val()  }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#eventsList').show();
        $('#eventsList').html('');
        $('#eventsList').append(data);
        $('[data-toggle="tooltip"]').tooltip();
    });
};

function ReloadDepartmentEvents()
{
    $('#eventsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/departament/ajaxevents',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'sorts': $("#sort").val(), 'confirm': $("#confirm").val() , 'confirm_dep': $("#confirm_dep").val()  }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#eventsList').show();
        $('#eventsList').html('');
        $('#eventsList').append(data);
        $('[data-toggle="tooltip"]').tooltip();
    });
};

function ReloadAdminDepartmentEvents()
{
    $('#eventsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/admin/events/ajaxevents',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'userId': $("#department").val(), 'sorts': $("#sort").val(), 'confirm': $("#confirm").val() , 'confirm_dep': $("#confirm_dep").val(), 'deleted': $("#deleted").val(), 'fooRoute': $("#fooRoute").val(), 'fooId': $("#fooId").val()    }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#eventsList').show();
        $('#eventsList').html('');
        $('#eventsList').append(data);
        $('[data-toggle="tooltip"]').tooltip();
    });
};

function ReloadAdminConserwatorEvents()
{
    $('#eventsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/superadmin/conservators/ajaxconservatorevents',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'userId': $("#conservator").val(), 'sorts': $("#sort").val(), 'confirm': $("#confirm").val() , 'confirm_dep': $("#confirm_dep").val(), 'deleted': $("#deleted").val(), 'fooRoute': $("#fooRoute").val(), 'fooId': $("#fooId").val()    }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#eventsList').show();
        $('#eventsList').html('');
        $('#eventsList').append(data);
        $('[data-toggle="tooltip"]').tooltip();
    });
};

function ReloadAdminConservators()
{
    $('#eventsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/superadmin/conservators/ajaxconservators',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'sorts': $("#sort").val(), 'dateStart': $("#datetimepicker1").val() , 'dateEnd': $("#datetimepicker2").val()   }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#eventsList').show();
        $('#eventsList').html('');
        $('#eventsList').append(data);
    });
};

function ReloadAdminLogs()
{
    $('#logsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/superadmin/logs/ajaxlogs',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val(), 'sorts': $("#sort").val(), 'dateStart': $("#datetimepicker1").val() , 'dateEnd': $("#datetimepicker2").val()   }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#logsList').show();
        $('#logsList').html('');
        $('#logsList').append(data);
    });
};

function ReloadAdminAdmins()
{
    $('#adminsList').hide();
    $('#spinner').show();
    $.ajax({
        url: '/superadmin/admins/ajaxadmins',
        type: 'GET',
        async: true,
        data: { 'page': $("#page").val()  }
    })
    .done(function( data ) {
        $('#spinner').hide();
        $('#adminsList').show();
        $('#adminsList').html('');
        $('#adminsList').append(data);
    });
};

