<?php
/**
 * Class for the holiday countdown widget
 * @package holiday-countdown
*/

// Make sure this file isn't called directly
if ( !function_exists( 'add_action' ) )
  die( 'Nothing to see here! Move along...' );

class HolidayCountdownWidget extends WP_Widget {
  // List of holiday names
  private $holiday_names = array(
    'new-years' => 'New Year\'s',
    'mlk-day' => 'Martin Luther King Jr. Day',
    'groundhog-day' => 'Groundhog Day',
    'valentines-day' => 'Valentine\'s Day',
    'presidents-day' => 'President\'s Day',
    'easter' => 'Easter',
    'daylight-begin' => 'Beginning of Daylight Savings Time',
    'st-patricks-day' => 'St. Patrick\'s Day',
    'mothers-day' => 'Mother\'s Day',
    'memorial-day' => 'Memorial Day',
    'fathers-day' => 'Father\'s Day',
    'independence-day' => 'Independence Day',
    'labor-day' => 'Labor Day',
    'columbus-day' => 'Columbus Day',
    'halloween' => 'Halloween',
    'veterans-day' => 'Veteran\'s Day',
    'daylight-end' => 'Ending of Daylight Savings Time',
    'thanksgiving' => 'Thanksgiving',
    'black-friday' => 'Black Friday',
    'christmas' => 'Christmas'
  );

  // A list of holiday dates
  private $holiday_dates = array(
    'new-years' => '01-01',
    'mlk-day' => '*3-1-01',
    'groundhog-day' => '02-02',
    'valentines-day' => '02-14',
    'presidents-day' => '*3-1-02',
    'easter' => '&',
    'daylight-begin' => '*2-0-03',
    'st-patricks-day' => '03-17',
    'mothers-day' => '*2-0-05',
    'memorial-day' => '#1-05',
    'fathers-day' => '*3-0-06',
    'independence-day' => '07-04',
    'labor-day' => '*1-1-09',
    'columbus-day' => '*2-1-10',
    'halloween' => '10-31',
    'veterans-day' => '11-11',
    'daylight-end' => '*1-0-11',
    'thanksgiving' => '*4-4-11',
    'black-friday' => '*4-5-11',
    'christmas' => '12-25'
  );

  /**
   * Function: __construct
   * Creates the widget
  */
  public function __construct() {
    $widget_options = array(
      'classname' => 'holiday-countdown-widget',
      'description' => 'Show a countdown timer for a holiday'
    );
    parent::__construct( 'holiday-countdown-widget', 'Holiday Countdown', $widget_options );
  }

  /**
   * Function: widget
   * The content that is displayed on the actual WordPress site
   *
   * @param $args
   * @param $instance
  */
  public function widget( $args, $instance ) {
    // Timer display stuff
    $id = $args[ 'widget_id' ];

    if ( $instance[ 'holiday_type' ] == 'preset' ) {
      $widget_title = $this->holiday_names[ $instance[ 'holiday' ] ];
      $widget_date = $this->holiday_dates[ $instance[ 'holiday' ] ];
    } else {
      $widget_title = $instance[ 'custom_title' ];
      $widget_date = $instance[ 'custom_month' ] . '/' . $instance[ 'custom_day' ];
    }
    ?>
    <h1>Countdown to <?php echo $widget_title; ?></h1>
    <p id="<?php echo $id; ?>"></p>
    <script type="text/javascript">
    newTimer('<?php echo $id; ?>', '<?php echo $widget_date; ?>');
    </script>
    <?php
  }

  /**
   * Function: form
   * The form for the widget settings on the back end
   *
   * @param $form
  */
  public function form( $instance ) {
    $holiday_type = isset( $instance[ 'holiday_type' ] ) ? $instance[ 'holiday_type' ] : 'preset';
    $holiday = isset( $instance[ 'holiday' ] ) ? $instance[ 'holiday' ] : 'new-years';
    $custom_title = isset( $instance[ 'custom_title' ] ) ? $instance[ 'custom_title' ] : 'Custom Holiday';
    $custom_month = isset( $instance[ 'custom_month' ] ) ? $instance[ 'custom_month' ] : '01';
    $custom_day = isset( $instance[ 'custom_day' ] ) ? $instance[ 'custom_day' ] : '01';
    $holiday_type_field = $this->get_field_name( 'holiday_type' );
    $holiday_field = $this->get_field_name( 'holiday' );
    $custom_title_field = $this->get_field_name( 'custom_title' );
    $custom_month_field = $this->get_field_name( 'custom_month' );
    $custom_day_field = $this->get_field_name( 'custom_day' );
    ?>
    <p>
      <!-- Preset holiday -->
      <input type="radio" name="<?php echo $holiday_type_field; ?>" value="preset" <?php if ( $holiday_type == 'preset' ) echo 'checked'; ?>>Use Preset Holiday<br />

      <label for="<?php echo $holiday_field; ?>">Select Holiday:</label>
      <select id="<?php echo $holiday_field; ?>" name="<?php echo $holiday_field; ?>">
        <option value="new-years" <?php if ( $holiday == 'new-years' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'new-years' ]; ?></option>
        <option value="mlk-day" <?php if ( $holiday == 'mlk-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'mlk-day' ]; ?></option>
        <option value="groundhog-day" <?php if ( $holiday == 'groundhog-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'groundhog-day' ]; ?></option>
        <option value="valentines-day" <?php if ( $holiday == 'valentines-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'valentines-day' ]; ?></option>
        <option value="presidents-day" <?php if ( $holiday == 'presidents-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'presidents-day' ]; ?></option>
        <option value="easter" <?php if ( $holiday == 'easter' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'easter' ]; ?></option>
        <option value="daylight-begin" <?php if ( $holiday == 'daylight-begin' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'daylight-begin' ]; ?></option>
        <option value="st-patricks-day" <?php if ( $holiday == 'st-patricks-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'st-patricks-day' ]; ?></option>
        <option value="mothers-day" <?php if ( $holiday == 'mothers-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'mothers-day' ]; ?></option>
        <option value="memorial-day" <?php if ( $holiday == 'memorial-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'memorial-day' ]; ?></option>
        <option value="fathers-day" <?php if ( $holiday == 'fathers-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'fathers-day' ]; ?></option>
        <option value="independence-day" <?php if ( $holiday == 'independence-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'independence-day' ]; ?></option>
        <option value="labor-day" <?php if ( $holiday == 'labor-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'labor-day' ]; ?></option>
        <option value="columbus-day" <?php if ( $holiday == 'columbus-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'columbus-day' ]; ?></option>
        <option value="halloween" <?php if ( $holiday == 'halloween' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'halloween' ]; ?></option>
        <option value="veterans-day" <?php if ( $holiday == 'veterans-day' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'veterans-day' ]; ?></option>
        <option value="daylight-end" <?php if ( $holiday == 'daylight-end' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'daylight-end' ]; ?></option>
        <option value="thanksgiving" <?php if ( $holiday == 'thanksgiving' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'thanksgiving' ]; ?></option>
        <option value="black-friday" <?php if ( $holiday == 'black-friday' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'black-friday' ]; ?></option>
        <option value="christmas" <?php if ( $holiday == 'christmas' ) echo 'selected'; ?>><?php echo $this->holiday_names[ 'christmas' ]; ?></option>
      </select><br />
      <!-- /Preset holiday -->
      <hr />
      <!-- Custom holiday -->
      <input type="radio" name="<?php echo $holiday_type_field; ?>" value="custom" <?php if ( $holiday_type == 'custom' ) echo 'checked'; ?>>Use Custom Holiday<br />

      <label for="<?php echo $custom_title_field; ?>">Holiday Name:</label>
      <input type="text" id="<?php echo $custom_title_field; ?>" name="<?php echo $custom_title_field; ?>" value="<?php echo $custom_title; ?>"><br />

      <label for="<?php echo $custom_month_field; ?>">Holiday Month:</label>
      <select id="<?php echo $custom_month_field; ?>" name="<?php echo $custom_month_field; ?>" onchange="update_holiday_form( '<?php echo $custom_day_field; ?>', '<?php echo $custom_month_field; ?>', '<?php echo $custom_day; ?>' )">
        <option value="01" <?php if ( $custom_month == '01' ) echo 'selected'; ?>>January</option>
        <option value="02" <?php if ( $custom_month == '02' ) echo 'selected'; ?>>February</option>
        <option value="03" <?php if ( $custom_month == '03' ) echo 'selected'; ?>>March</option>
        <option value="04" <?php if ( $custom_month == '04' ) echo 'selected'; ?>>April</option>
        <option value="05" <?php if ( $custom_month == '05' ) echo 'selected'; ?>>May</option>
        <option value="06" <?php if ( $custom_month == '06' ) echo 'selected'; ?>>June</option>
        <option value="07" <?php if ( $custom_month == '07' ) echo 'selected'; ?>>July</option>
        <option value="08" <?php if ( $custom_month == '08' ) echo 'selected'; ?>>August</option>
        <option value="09" <?php if ( $custom_month == '09' ) echo 'selected'; ?>>September</option>
        <option value="10" <?php if ( $custom_month == '10' ) echo 'selected'; ?>>October</option>
        <option value="11" <?php if ( $custom_month == '11' ) echo 'selected'; ?>>November</option>
        <option value="12" <?php if ( $custom_month == '12' ) echo 'selected'; ?>>December</option>
      </select><br />

      <label for="<?php echo $custom_day_field; ?>">Holiday Day:</label>
      <select id="<?php echo $custom_day_field; ?>" name="<?php echo $custom_day_field; ?>"></select>
      <!-- /Custom holiday -->
    </p>

    <script type="text/javascript">
    update_holiday_form( '<?php echo $custom_day_field; ?>', '<?php echo $custom_month_field; ?>', '<?php echo $custom_day; ?>' );
    </script>
    <?php
  }

  /**
   * Function: update
   * Processes widget option on save
   *
   * @param $new_instance
   * @param $old_instance
   *
   * @return array
  */
  public function update( $new_instance, $old_instance ) {
    $old_instance[ 'holiday_type' ] = $new_instance[ 'holiday_type' ];
    $old_instance[ 'holiday' ] = $new_instance[ 'holiday' ];
    $old_instance[ 'custom_title' ] = $new_instance[ 'custom_title' ];
    $old_instance[ 'custom_month' ] = $new_instance[ 'custom_month' ];
    $old_instance[ 'custom_day' ] = $new_instance[ 'custom_day' ];

    return $old_instance;
  }
}

add_action( 'widgets_init', function() {
  register_widget( 'HolidayCountdownWidget' );
} );
?>
