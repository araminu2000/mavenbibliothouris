/* Application JS Main File */

var Courses = (function(){


    var CONFIGS    =   {

          DataTables    : {
                  Members :  {

                      "aoColumns": [
                          { "sTitle": "Name" }
                      ],
                      bJQueryUI : true
                  },

                  Courses : {
                      "aoColumns": [
                          { "sTitle": "Date Start" },
                          { "sTitle": "Date End" },
                          { "sTitle": "Title"},
                          { "sTitle": "Trainer"},
                          { "sTitle": "&nbsp;"}
                      ],
                      bJQueryUI : true
                  },

                  Followed : {
                      "aoColumns" : [
                          { "sTitle" : "Date Start" },
                          { "sTitle" : "Date End" },
                          { "sTitle" : "Title" },
                          { "sTitle" : "Trainer" }
                      ],
                      bJQueryUI : true
                  }
          },

          Menu : { /* To be implemented some day in the future */ },

          DatePickers : {
                  Members : {
                      dateFormat : "yy-mm-dd"
                  }
          },

          URLs : {
              courseDetails : '/bibliothouris/courses/detail?id='
          }

    };

    var _initMainMenu   =   function() {
            $( "ul#menu" ).menu();

            return true;
    };

    var _initDataTables =  {

        Courses :   function() {
            $('#courses-list').dataTable(CONFIGS.DataTables.Courses);
        },

        Members :   function() {
            $('#members-list').dataTable(CONFIGS.DataTables.Members);
        },

        Followed : function() {
            $('#courses-followed-list').dataTable(CONFIGS.DataTables.Followed);
        },

        All : function() {
            this.Courses();
            this.Members();
            this.Followed();
        }

    };

    var _initDatePickers = {

        Courses : function() {

            if ($('#date_start').length > 0) {
                $('#date_start').datepicker(CONFIGS.DatePickers.Members);
            }

            if ($('#date_end').length > 0) {
               $('#date_end').datepicker(CONFIGS.DatePickers.Members);
            }
        }

    };

    var _getDataTables = {
        Courses : function() {
            return $('#courses-list').dataTable();
        },

        Members : function() {
            return $('#members-list').dataTable();
        },

        Followed: function() {
            return $('#courses-followed-list').dataTable();
        }
    }

    var _prepareCoursesListTableData = function(a) {

        for (var i  = 0 ; i< a.length; i++) {
            a[i][4] = '<a href="'+ CONFIGS.URLs.courseDetails + a[i][4] + '" class="buttons">' + 'Details' + '</a>';
        }

       return a;
    }

    return {

        Init : function() {

            _initMainMenu();
            _initDataTables.Courses();
            _initDataTables.Members();
            _initDataTables.Followed();
            _initDatePickers.Courses();

            $('.course-enrollment').bind('click', Courses.handleEnrollButton);
            $('.course-enrollment-back').bind('click', Courses.handleCourseEnrollmentBackBtn)

            return true;
        },

        Abandon : function() {
            return true;
        },

        handleEnrollButton  : function() {

            var vars = $(this).attr('id').split("_");

            var courseId    =   vars[0];
            var memberId    =   vars[1];

            if(courseId && memberId) {
                window.location = '/bibliothouris/courses/enroll?cid=' + courseId + '&mid=' + memberId;
            }
        },

        handleCourseEnrollmentBackBtn   : function(e) {
            window.location = '/bibliothouris/courses/index';
        },

        LoadMembersListFromDb : function(url, callBack) {

            var cbSend = Courses.HandleMembersListLoadSuccess

            if ('function' == typeof callBack) {
                cbSend = callBack;
            }

            $.ajax({
                dataType : "json",
                url      : url,
                success  : cbSend
            });

            delete callBack;
            delete cbSend;
        },

        HandleMembersListLoadSuccess : function(d) {
            if(d && d instanceof Array) {

                var tblMembers = _getDataTables.Members();
                    tblMembers.fnClearTable();
                    tblMembers.fnAddData(d);
            }
        },

        LoadCoursesListFromDb : function(url, callBack) {

            var cbSend = Courses.HandleCoursesListLoadSuccess

            if ('function' == typeof callBack) {
                cbSend = callBack;
            }

            $.ajax({
                dataType : "json",
                url      : url,
                success  : cbSend
            });

            delete callBack;
            delete cbSend;
        },

        HandleCoursesListLoadSuccess : function(d) {

            if(d && d instanceof Array) {

                var tblCourses = _getDataTables.Courses();
                    tblCourses.fnClearTable();
                    tblCourses.fnAddData(
                        _prepareCoursesListTableData(d)
                    );

            }

        },

        LoadFollowedCoursesListFromDb : function(url, callBack) {


            var cbSend = Courses.HandleFollowedCoursesListLoadSuccess

            if ('function' == typeof callBack) {
                cbSend = callBack;
            }

            $.ajax({
                dataType : "json",
                url      : url,
                success  : cbSend
            });

            delete callBack;
            delete cbSend;
        },

        HandleFollowedCoursesListLoadSuccess : function(d) {

            if(d && d instanceof Array) {

                var tblCourses = _getDataTables.Followed();
                tblCourses.fnClearTable();
                tblCourses.fnAddData(d);

            }
        }
    }

})();