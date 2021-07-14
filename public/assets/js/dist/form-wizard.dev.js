"use strict";

$(function () {
  'use strict';

  $('#wizard1').steps({
    headerTag: 'h3',
    bodyTag: 'section',
    autoFocus: true,
    titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
  });
  $('#wizard3').steps({
    headerTag: 'h3',
    bodyTag: 'section',
    autoFocus: true,
    titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
    stepsOrientation: 1
  }); // //accordion-wizard
  // var options = {
  //     mode: 'wizard',
  //     autoButtonsNextClass: 'btn btn-danger float-right',
  //     autoButtonsPrevClass: 'btn btn-secondary',
  //     stepNumberClass: 'badge badge-primary mr-1',
  //     beforeNextStep: function(currentStep) {
  //         // alert(currentStep);
  //         switch (currentStep) {
  //             case 1:
  //                 alert('1221');
  //                 break;
  //             case 2:
  //                 alert('34234');
  //                 break;
  //         }
  //         return true;
  //     },
  //     onSubmit: function() {
  //         alert('AAAAA');
  //         return true;
  //     }
  // }
  // $("#form").accWizard(options);
});