<!DOCTYPE html>
<html lang="en" ng-app="notesApp">
<head>
    <title>Notes App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/app/app.css') }}">
    <script src="{{ url('assets/jquery/3.1.1/jquery.min.js') }}"></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body ng-controller="noteCtrl" ng-init="getNotes()">

<div class="header" ng-class="{'has-alert':alert.id != undefined}">
    <div class="container-fluid">
        <div class="logo pull-left hidden-sm hidden-xs">
            <img ng-src="https://data.mybos.com/9/2020-04-04/2HHYN46AYA.png" src="https://data.mybos.com/9/2020-04-04/2HHYN46AYA.png">
        </div>
        <div class="header-feature pull-left">
            <ul class="list-inline am-slide-left">
                <li>
                    <a class="icon header-menu" href="#"></a>&nbsp;&nbsp;
                    <a class="icon head mobile" href="#"></a>&nbsp;&nbsp;
                    <a class="icon head community" href="#"></a>&nbsp;&nbsp;
                    <a class="icon head notice" href="#"></a>&nbsp;&nbsp;
                    <a class="icon head booking" href="#"></a>&nbsp;&nbsp;

                    <a class="header-icon lobby" href="#" ui-sref="bm.lobby" uib-tooltip="Lobby Screen" tooltip-placement="bottom">
                        <img src="https://app.mybos.com/assets/img/icons/lobby-screen-icon.png">
                    </a>
                </li>
                <li class="relative ng-hide">
                    <a class="header-icon cloudsense" uib-tooltip="Cloudsense" tooltip-placement="bottom" ui-sref="bm.cloudsense" href="#!/cloudsense">
                        <i class="mb-ico ico-cloudsense"></i>
                    </a>
                    <div class="mb-sensor-notification" id="mb-sensor-notification" ui-sref="bm.cloudsense" href="#!/cloudsense">
                        <strong>Warning:</strong> One or more sensors requires attention
                        &nbsp;&nbsp;<i class="fa fa-times-circle-o" ng-click="warning = 0;$event.stopPropagation() "></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="time-weather pull-left hidden-md hidden-xs ng-binding">
            <span class="weather-icon"></span>
            <span class="weather-temp">
			</span>

            <span class="hours ng-binding"><script>
                const time = new Date();
                const bosTime =   time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                document.write(bosTime);
            </script></span>&nbsp;
            <?php echo date('l\, jS  F Y '); ?>
        </div>
        <div class="user-action pull-right">
            <p ng-click="showUserControl = !showUserControl; $event.stopPropagation()" class="ng-binding">
                Demo Manager &nbsp; <a class="icon drop-down" href="javascript:void(0)"></a>
            </p>
            <div class="drop-down-content am-fade ng-isolate-scope ng-hide" drop-down="showUserControl">
                <i class="angle right"></i>
                <ul>
                    <li><a href="#!/profile" ui-sref="bm.profile" mb-lang="">Profile</a></li>
                    <li><a href="javascript:void(0)" ng-click="showChangePass()" mb-lang="">Change Password</a></li>
                    <li><a href="javascript:void(0)" ng-click="logout()" mb-lang="">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="user-action pull-right">
            <p ng-click="showNotify = !showNotify; $event.stopPropagation()">
                <i class="fa fa-bell-o"></i>
                <span class="badge ng-binding" ng-show="notifyCount > 0" style="">16</span>
            </p>
            <div class="drop-down-content notify am-fade-and-slide-right ng-isolate-scope ng-hide" drop-down="showNotify">
                <div class="app-lock ng-hide" ng-show="loadingNotify" style=""></div>
                <div ng-show="notifications.length <= 0 &amp;&amp; systemNews.length <= 0" class="notification-empty ng-hide" ui-sref="bm.news" href="#!/what-new" style="">
                    <div class="notification-title flex-container flex-row">
                        <h4>Notifications</h4>
                        <a href="#!/what-new" ui-sref="bm.news" ng-click="showNotify = false">
                            <span></span>
                            <mb-lang>What's New?</mb-lang>
                        </a>
                    </div>
                    <div class="empty-img">

                    </div>
                </div>
                <div ng-hide="notifications.length <= 0 &amp;&amp; systemNews.length <= 0">
                    <div class="notification-title flex-container flex-row">
                        <h4>Notifications</h4>
                        <a href="#!/what-new" ui-sref="bm.news" ng-click="showNotify = false">
                            <span></span>
                            <mb-lang>What's New?</mb-lang>
                        </a>
                    </div>
                    <div class="notification-list ng-isolate-scope mb-scroller" mb-scroller="" action="scrolled" data-scrollbar="true" tabindex="-1" style="overflow: hidden; outline: currentcolor none medium;"><div class="scroll-content"><div ng-transclude="">

                            </div></div><div class="scrollbar-track scrollbar-track-x" style="display: none;"><div class="scrollbar-thumb scrollbar-thumb-x"></div></div><div class="scrollbar-track scrollbar-track-y" style="display: none;"><div class="scrollbar-thumb scrollbar-thumb-y"></div></div></div>
                    <div class="flex-container end">
                        <span class="notification-clear" ng-click="clearNotification()">Clear all</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-action pull-right">
            <p ng-click="showLanguageSelector = !showLanguageSelector; $event.stopPropagation()" class="ng-binding">
                English &nbsp; <a class="icon drop-down" href="javascript:void(0)"></a>
            </p>
            <div class="drop-down-content languages am-fade ng-isolate-scope ng-hide" drop-down="showLanguageSelector">
                <i class="angle right"></i>
                <ul>
                    <li><!-- ngRepeat: (code,lang) in languageList --><a href="javascript:void(0)" ng-click="changeLanguage(code)" ng-repeat="(code,lang) in languageList" class="ng-binding ng-scope" style="">English</a><!-- end ngRepeat: (code,lang) in languageList --><a href="javascript:void(0)" ng-click="changeLanguage(code)" ng-repeat="(code,lang) in languageList" class="ng-binding ng-scope">Spanish  (Spanish)</a><!-- end ngRepeat: (code,lang) in languageList --><a href="javascript:void(0)" ng-click="changeLanguage(code)" ng-repeat="(code,lang) in languageList" class="ng-binding ng-scope">Tiếng Việt (Vietnamese)</a><!-- end ngRepeat: (code,lang) in languageList --></li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- ngIf: showCalculator && isFeatureEnable(FEATURES.CALCULATOR) -->
</div>

<div class="container col-md-4"  style="background-color: #f6d746; margin-top: 70px;padding: 25px;min-height: 400px;border-radius: 10px;">
    <div><h4 class="pageHeader">Notes</h4> <i ng-click="addNoteModal()" style="float: right; font-size: 27px;" class="fa fa-plus-circle"></i></div>
    <div class="clearfix"></div>
    <div style="margin-top: 10px; margin-bottom: 10px">
        <input type="text" class="form-control" style="width: 100%" ng-model="search"ng-keypress="($event.charCode==13)? searchNotes() : return" >
    </div>
    <div class="card" style="margin-bottom: 10px; background-color: #ffea9a !important" ng-repeat="note in notes">
        <div class="card-body">
            <div  class="card-title">
                <h5 style="width: 80%;float: left;font-weight: bold;font-size: 15px;"><% note.author %> - <% note.created_at | date:'dd-MM-yyyy'%></h5>
                <i ng-click="deleteNoteModal(note)" style="float: right; margin-left: 10px;" class="fa fa-trash"></i>
                <i ng-click="editNoteModal(note)" style="float: right;" class="fa fa-edit"></i>
            </div>
            <div class="clearfix"></div>
            <p class="card-text" ng-bind-html="note.note | linebreaks" ></p>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addNoteModel" tabindex="-1" role="dialog" aria-labelledby="addNoteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><% action %> Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>

                        <label>Author:</label><br>
                        <input type="text"  class="form-control" name="author" ng-model="author" style="width: 100%;" required ><br>
                        <label>Note:</label>
                        <textarea ng-model="note" class="form-control"  rows="5" style="width: 100%;white-space: pre-wrap;" required ></textarea> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" ng-if="action==='Add'" class="btn btn-primary" ng-click="addNote()">Save</button>
                    <button type="button" ng-if="action==='Edit'" class="btn btn-primary" ng-click="editNote()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteNoteModel" tabindex="-1" role="dialog" aria-labelledby="deleteNoteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Are You sure you want delete following Note ?</h6>
                    <p  ng-bind-html="deletingNote.note | linebreaks" ></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" ng-click="deleteNote()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <nav aria-label="Page navigation example">
            <notes-pagination></notes-pagination>
        </nav>
    </div>

</div>
<script src="{{ url('assets/angularjs/1.8.0/angular.min.js') }}"></script>
<script src="{{ url('assets/angularjs/1.8.0/angular-resource.min.js') }}"></script>
<script src="{{ url('assets/app/app.js') }}"></script>
</body>
</html>

