// Code goes here
var app = angular.module('notesApp', ['ngResource'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.factory( 'noteFactory', function($resource){
    return $resource('api/notes');
});

app.filter('linebreaks', function($sce) {
    return function(text) {
        if(text){
            var formattedText = text.replace(/\n/g, "<br>");
            return $sce.trustAsHtml(formattedText);
        }

    }
});

app.directive('notesPagination', function(){
    return{
        restrict: 'E',
        template: '<ul ng-if="total!=0" class="pagination">'+
            '<li class="page-item" ng-show="currentPage != 1"><a href="javascript:void(0)" class="page-link" ng-click="getNotes(1)">&laquo;</a></li>'+
            '<li class="page-item" ng-show="currentPage != 1"><a href="javascript:void(0)" class="page-link" ng-click="getNotes(currentPage-1)">&lsaquo; Prev</a></li>'+
            '<li class="page-item" ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
            '<a href="javascript:void(0)" class="page-link" ng-click="getNotes(i)">{{i}}</a>'+
            '</li>'+
            '<li class="page-item" ng-show="currentPage != totalPages"><a href="javascript:void(0)" class="page-link" ng-click="getNotes(currentPage+1)">Next &rsaquo;</a></li>'+
            '<li class="page-item" ng-show="currentPage != totalPages"><a href="javascript:void(0)" class="page-link" ng-click="getNotes(totalPages)">&raquo;</a></li>'+
            '</ul>'
    };
});

app.controller('noteCtrl',function($scope, $sce, $http, noteFactory){

    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.notes = [];
    $scope.note = ' ';
    $scope.author = '';
    $scope.deletingNote = {};
    $scope.editingNote = {};
    $scope.search = '';
    $scope.total = 0;
    $scope.action = 'Add';

    $scope.addNoteModal = function(){
        $scope.action = 'Add';
        $('#addNoteModel').modal('show');
    }

    $scope.addNote = function(){
        $('#addNoteModel').modal('hide');
        var author = $scope.author;
        var note = $scope.note;
        $scope.author = '';
        $scope.note = '';
        $http({
            method: 'POST',
            url: 'api/notes',
            headers: {
                "Content-type": 'Content-Type: application/json'
            },
            data:  JSON.stringify({ author : author, note : note })
        }).then(function (response) {
            alert(response.data.message);
            $scope.getNotes();
        }, function (response) {
            console.log('i am in error');
            $scope.getNotes();
        });
    }

    $scope.editNoteModal = function(note){
        $scope.action = 'Edit';
        $scope.editingNote = note;
        $scope.author = $scope.editingNote.author;
        $scope.note = $scope.editingNote.note;
        $('#addNoteModel').modal('show');
    }

    $scope.editNote = function(){
        $('#addNoteModel').modal('hide');
        var author = $scope.author;
        var note = $scope.note;
        $scope.author = '';
        $scope.note = '';
        $http({
            method: 'PUT',
            url: 'api/notes/' + $scope.editingNote.id,
            headers: {
                "Content-type": 'Content-Type: application/json'
            },
            data:  JSON.stringify({ author : author, note : note })
        }).then(function (response) {
            alert(response.data.message);
            $scope.getNotes();
        }, function (response) {
            console.log('i am in error');
            $scope.getNotes();
        });
    }

    $scope.deleteNoteModal = function(note){
        $scope.deletingNote = note;
        $('#deleteNoteModel').modal('show');
    }

    $scope.deleteNote = function(){
        $('#deleteNoteModel').modal('hide');
        $http({
            method: 'DELETE',
            url: 'api/notes/'+$scope.deletingNote.id,
            headers: {
                "Content-type": undefined
            },
            data: { author : $scope.author, note : $scope.note }
        }).then(function (response) {
            alert(response.data.message);
            $scope.getNotes();
        }, function (response) {
            console.log('i am in error');
            $scope.getNotes();
        });
    }

    $scope.getNotes = function(pageNumber){

        if(pageNumber===undefined){
            pageNumber = '1';
        }

        var payload = { page: pageNumber };
        if($scope.search){
            payload.search = $scope.search;
        }

        noteFactory.get(payload , function(response){
            $scope.notes        = response.data;
            $scope.totalPages   = response.last_page;
            $scope.total        = response.total;
            $scope.currentPage  = response.current_page;
            // Pagination Range
            var pages = [];
            for(var i=1;i<=response.last_page;i++) {
                pages.push(i);
            }
            $scope.range = pages;

        });

    };

    $scope.searchNotes = function () {
        $scope.getNotes();
    }

});
