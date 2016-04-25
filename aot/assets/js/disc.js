var QUESTION_NUMBER_IN_ONE_NAV_COLUMN = 5;   //number of questions shown in one navigation bar column
var examId = 0;
var examName = '';
var examQuestions = new Array();
var currentQuestionIndex = null;
var currentAnswers_m = {};
var currentAnswers_j = {};
var feedbackNeeded = {};
var elapsedTime = 0;

jQuery(function() {
  if (jQuery('#exam-ui').length) 
  {

    $.ajax({
    type: "POST",
    url: "../users/get_user_disc_data/",
    async: false, 
    success: function(response)
    {
      var data = $.parseJSON(response);
      examQuestions = data.questions;
      // Add answers to the current answers map if we have any
      /*if (data.answers && data.answers.length) {
        for (var i = 0; i < data.answers.length; i++) {
          var answer = data.answers[i];
          currentAnswers[(answer.questionIndex - 1)] = answer.answerId;
        }
      }*/
    loadQuestion(0);
    displayExamUI();
    updateQuestionStates();

      //re-active the first question
      jQuery('#question_nav_' + 0).addClass('active_question');
    }
    });
  }
	
  if (jQuery('#exam-time-left').length && EXAM_TIME_LEFT) {
    updateExamTimer();
  }
});

/**
 * Hide the loading message and display the actual exam UI
 */
function displayExamUI() {

  // Hide loading message
  jQuery('#loading').hide();

  // Set some info in the ui
  jQuery('#exam-name').text(examName);
  jQuery('#question-count').text(examQuestions.length);
  // build the navigation bar
  var navQuestions;
  for (var i = 0; i < examQuestions.length; i++) {
    if (i % QUESTION_NUMBER_IN_ONE_NAV_COLUMN == 0) {
        topic = examQuestions[i].topic;
        var navArea = jQuery('#navigation-area');
        var navUl = jQuery('<ul/>');
        var navBar = 'question-nav' + (i / QUESTION_NUMBER_IN_ONE_NAV_COLUMN + 1);
        navUl.attr('id', navBar);
        navUl.attr('class', 'pagination');
        navArea.append(navUl);
        var navTopic = jQuery('<li/>');
        navUl.append(navTopic);
        navQuestions = jQuery('<ul/>');
        navTopic.append(navQuestions);
    }

    var navLink = jQuery('<a/>');
    navLink.attr('id', 'question_nav_' + i);
    navLink.attr('href', 'javascript:void(0);');
    navLink.attr('style', 'width: 15px; text-align: center;');
    navLink.attr('class', 'question_unanswered');
    navLink.text((i + 1));          //generate list of question links in navigation bar
    navLink.click(function() { navigateToQuestion(jQuery(this)); });

    var answeredText = jQuery('<span/>');
    answeredText.text(' (Answered)');
    answeredText.hide();
    navLink.append(answeredText);

    var navList = jQuery('<li/>');
    navList.attr('id', 'nav-list-' + i);
    navList.append(navLink);
    navList.append(answeredText);

    navQuestions.append(navList);
  }

  // Add click event to the buttons
  jQuery('#skip-button').click(function() { skipQuestion(); });
  jQuery('#record-answer-button').click(function() { recordAnswer(); });
  jQuery('#finish-exam-button').click(function() { confirmAndFinishExam(); });

  // Show the actual UI
  jQuery('#exam-ui').show();

}

/**
 * Set the proper state labels on all the questions
 */
function updateQuestionStates() {
  var topic_counter = -1;
  var topic = '';
  for (var i = 0; i < examQuestions.length; i++) {
    if (examQuestions[i].topic != topic) {
        topic_counter++;
        topic = examQuestions[i].topic;
    }
    if (currentAnswers_m[i] && currentAnswers_j[i]) {
        jQuery('#nav-list-' + i + ' a').attr('class', 'question_answered_question');
    }
  }
}

/**
 * Hide the exam UI
 */
function hideExamUI() {
  jQuery('#exam-ui').hide();
}

function deactiveQuestion(index) {
    // Color the active question
    jQuery('#question_nav_' + index).removeClass('active_question');
}

/**
 * Load the specified question
 */
function loadQuestion(index) {

  if (index >= examQuestions.length) 
  {
    index = 0;
  }
  currentQuestionIndex = index;

  var question = examQuestions[currentQuestionIndex];

  // Set some info in the ui
  jQuery('#question-index').text((currentQuestionIndex + 1));
  jQuery('#topic-name').html(question.topic);
  jQuery('#question-text').html(question.text);
  jQuery('#question-id').val(question.question_id);

  // Add the questions
  jQuery('#answers').empty();
  for (var i = 0; i < question.answers.length; i++) {

    var answer = question.answers[i];

    var li = jQuery('<li />');
    var radio_m = jQuery("<input type='radio' name='answer_m' id='" + 'answer_m_' + i + "' />");
    var radio_j = jQuery("<input type='radio' name='answer_j' id='" + 'answer_j_' + i + "' />");
    radio_m.val(answer.id_m);
    radio_j.val(answer.id_j);

    if (currentAnswers_m[currentQuestionIndex] && currentAnswers_m[currentQuestionIndex] == answer.id_m) {
      radio_m.attr('checked', 'checked');
    }

    if (currentAnswers_j[currentQuestionIndex] && currentAnswers_j[currentQuestionIndex] == answer.id_j) {
      radio_j.attr('checked', 'checked');
    }	
	
    var label = jQuery('<label />');
    label.attr('for', 'answer_' + i);
    label.html(answer.text);
    label.attr('class', 'question_choice');

    li.append(radio_m);
    li.append(radio_j);
    li.append(label);
    jQuery('#answers').append(li);
  }
  jQuery('#answers').append('</ul>');

  // Color the active question
  jQuery('#question_nav_' + index).addClass('active_question');

  // Handle the skip button
  if (currentQuestionIndex == examQuestions.length - 1) {
    jQuery('#skip-button').hide();
  } else {
    jQuery('#skip-button').show();
  }

}

// Clears the feedback checkbox
function clearFeedback() {
  if (jQuery('#register-feedback').is(':checked')) {
    jQuery('#register-feedback').removeAttr('checked');
  }
}

function skipQuestion() {
  clearFeedback();
  deactiveQuestion(currentQuestionIndex);
  loadQuestion(currentQuestionIndex + 1);
}

function navigateToQuestion(caller) {
  var callerId = caller.attr('id').replace('question_nav_', '');
  clearFeedback();
  deactiveQuestion(currentQuestionIndex);
  loadQuestion(parseInt(callerId));
}

/**
 * recordAnswer: if Submit button is shown, record answer button will only submit the answer of the question
 * if not, recordAnswer will submit the answer as well as the rating.
 */
function recordAnswer() {

  // Find the checked element
  checkedElement_m = jQuery("#answers input[name='answer_m']:checked");
  checkedElement_j = jQuery("#answers input[name='answer_j']:checked");
  if (checkedElement_m.length && checkedElement_j.length) {
    var answerId_m = checkedElement_m.val();
    var answerId_j = checkedElement_j.val();
    currentAnswers_m[currentQuestionIndex] = answerId_m;
    currentAnswers_j[currentQuestionIndex] = answerId_j;
    jQuery.ajax({
      type: 'POST',
      url: '../users/save_answer_disc.php',
      async: false, 
      data: {id: examId, q: jQuery('#question-id').val(), m: answerId_m, j:answerId_j},
      success: function(data) {
        if (data != 'success') {
            if (data == 'relogin') {
                window.location = '/users/login.php';
            } else {
                showError(data);
            }
        }
      }
    });
    updateQuestionStates();
  }
  clearFeedback();

  deactiveQuestion(currentQuestionIndex);
  // Navigate to the next question
  loadQuestion(currentQuestionIndex + 1);
}


function confirmAndFinishExam() {

  if (confirm('Are you sure you wish to finish this exam?')) {
    finishExam();
  }

}

function finishExam() {

  hideExamUI();
  jQuery('#submitting').show();

  var answers = new Array();
  for (var i = 0; i < examQuestions.length; i++) {

    var questionId = examQuestions[i].id;
    var answerId_m = null;
    var answerId_j = null;

    if (currentAnswers_m[questionId]) {
      answerId_m = currentAnswers_m[questionId];
    }
	
    if (currentAnswers_j[questionId]) {
      answerId_j = currentAnswers_j[questionId];
    }

    if (answerId_m != null) {
      answers.push({'index': (i + 1), 'answerId_m': answerId_m});
    }
	
    if (answerId_j != null) {
      answers.push({'index': (i + 1), 'answerId_j':answerId_j});
    }
	
  }

  jQuery.ajax({
    type: 'POST',
    url: '../users/finish_user_disc.php',
    async: false, 
    data: {id: examId},
    success: function(data) {

      if (data == 'success') {
        document.location.href = '../users/submit_disc/';
      } else {
        jQuery('#submitting').hide();
        if (data == 'relogin') {
            window.location = '/users/login.php';
        } else {
            showError(data);
        }
      }

    }
  });

}

function showError(m) {

  jQuery('#error-text').text(m);
  jQuery('#error-message').show();

}

function updateExamTimer() {

  var timeLeft = EXAM_TIME_LEFT - elapsedTime;
  elapsedTime += 1;

  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;

  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }


  if (timeLeft <= 0) {

    alert('Your exam has timed out. You will now be redirected to the exam submission screen.');

    // If we're in ajax mode, submit via ajax - otherwise, redirect to the completion page
    if (jQuery('#exam-ui').length) {
      finishExam(false);
    } else {
      document.location.href = 'complete.php?id=' + EXAM_REQUEST_ID;
    }

  } else {
    jQuery('#exam-time-left').val(hours + ':' + minutes + ':' + seconds);
    setTimeout('updateExamTimer()', 1000);
  }

}

//form tags to omit in NS6+:
var omitformtags = ['input', 'textarea', 'select'];

omitformtags = omitformtags.join('|');

function disableselect(e) {
if (omitformtags.indexOf(e.target.tagName.toLowerCase()) == -1)
return false;
}

function reEnable() {
return true;
}

if (typeof document.onselectstart != 'undefined')
document.onselectstart = new Function('return false');
else {
document.onmousedown = disableselect;
document.onmouseup = reEnable;
}
