/**
 * Updates the custom holiday form when values are changed
 *
 * @param string dayElementID
*/
function update_holiday_form( dayElementID, monthElementID, currentDay ) {
  var dayElement = document.getElementById(dayElementID);
  var monthElement = document.getElementById(monthElementID);

  // Clear the day select input
  while ( dayElement.firstChild )
    dayElement.removeChild( dayElement.firstChild );

  // Populate the day select input with days in month
  var year = new Date().getFullYear();
  var dayCount = new Date( year, monthElement.value, 0 ).getDate();
  for ( var i = 0; i < dayCount; i++ ) {
    var node = document.createElement( "option" );

    var nodeValue;
    if ( i > 8 )
      nodeValue = i + 1;
    else
      nodeValue = "0" + ( i + 1 );

    if ( nodeValue == currentDay )
      node.selected = true;

    node.value = nodeValue;
    node.innerText = nodeValue;

    dayElement.appendChild( node );
  }
}
