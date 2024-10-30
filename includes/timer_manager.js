/**
 * Creates a new countdown timer to the supplied date
 *
 * @param string element
 * @param string dateString
*/
function newTimer(element, dateString) {
  var date;
  var year = new Date().getFullYear();

  // Get date
  date = getDate(year, dateString);

  // Check if we should use this year's holiday or next year's
  var holidaySeconds = getDateSeconds(Date.parse(year + '-' + date + ' 00:00:00'));
  var nowSeconds = getDateSeconds(Date.now());

  if (holidaySeconds < nowSeconds) {
    // Date has already passed, use next year's date
    year++;
    date = getDate(year, dateString);
    holidaySeconds= getDateSeconds(Date.parse(year + '-' + date + ' 00:00:00'));
  }

  var timeDifference = holidaySeconds - nowSeconds;

  timerOutput(element, timeDifference);
  window.setInterval(function() {
    timeDifference--;
    timerOutput(element, timeDifference);
  }, 1000);
}

/**
 * Outputs the timer to the supplied element's inner text
 *
 * @param string element
 * @param string timeDifference
*/
function timerOutput(element, timeDifference) {
  var days = Math.floor(timeDifference / 86400);
  var hours = Math.floor((timeDifference - (days * 86400)) / 3600);
  var minutes = Math.floor((timeDifference - (days * 86400) - (hours * 3600)) / 60);
  var seconds = timeDifference - (days * 86400) - (hours * 3600) - (minutes * 60);

  var output = '';
  var toAppend;
  if (days > 0) {
    if (days == 1)
      toAppend = ' day ';
    else
      toAppend = ' days ';

    output += (days + toAppend);
  }

  if (days > 0 || hours > 0) {
    if (hours == 1)
      toAppend = ' hour ';
    else
      toAppend = ' hours ';

    output += (hours + toAppend);
  }

  if (days > 0 || hours > 0 || minutes > 0) {
    if (minutes == 1)
      toAppend = ' minute ';
    else
      toAppend = ' minutes ';

    output += (minutes + toAppend);
  }

  if (seconds == 1)
    toAppend = ' second ';
  else
    toAppend = ' seconds ';

  output += (seconds + toAppend);

  document.getElementById(element).innerText = output;
}

/**
 * Gets the date in seconds
 *
 * @param string date
 *
 * @return string
*/
function getDateSeconds(date) {
  return Math.floor(date / 1000);
}

/**
 * Figures out the format of the date and finds the actual date accordingly
 *
 * @param string year
 * @param string dateString
 *
 * @return string
*/
function getDate(year, dateString) {
  var date;

  if (dateString.startsWith('*'))
    date = getNthDay(year, dateString);
  else if (dateString.startsWith('#'))
    date = getLastDay(year, dateString);
  else if (dateString == '&')
    date = findEaster(year);
  else
    date = dateString;

  return date;
}

/**
 * Get's the nth day in a month
 *
 * @param string year
 * @param string dateString
 *
 * @return string
*/
function getNthDay(year, dateString) {
  var dateInfo = dateString.substr(1).split('-');

  var day = 1;
  while (new Date(year + '-' + dateInfo[2] + '-' + day).getDay() != dateInfo[1])
    day++;

  return dateInfo[2] + '-' + (day + (7 * (dateInfo[0] - 1)));
}

/**
 * Gets the last day in a month
 *
 * @param string year
 * @param string dateString
 *
 * @return string
*/
function getLastDay(year, dateString) {
  var dateInfo = dateString.substr(1).split('-');

  var day = new Date(year, dateInfo[1], 0).getDate();
  while (new Date(year + '-' + dateInfo[1] + '-' + day).getDay() != dateInfo[0]);
    day--;

  day--;
  return dateInfo[1] + '-' + day;
}

/**
 * Since Easter is a hard holiday to calculate, we need to create a separate function to find it
 *
 * @param string year
 *
 * @return string
*/
function findEaster(year) {
  var C = Math.floor(year / 100);
    var N = year - 19 * Math.floor(year / 19);
    var K = Math.floor((C - 17) / 25);
    var I = C - Math.floor(C / 4) - Math.floor((C - K) / 3) + 19 * N + 15;
    I = I - 30 * Math.floor((I / 30));
    I = I - Math.floor(I / 28) * (1 - Math.floor(I / 28) * Math.floor(29 / (I + 1)) * Math.floor((21 - N) / 11));
    var J = year + Math.floor(year / 4) + I + 2 - C + Math.floor(C / 4);
    J = J - 7 * Math.floor(J / 7);
    var L = I - J;
    var M = 3 + Math.floor((L + 40) / 44);
    var D = L + 28 - 31 * Math.floor(M / 4);

    return M + '-' + D;
}
