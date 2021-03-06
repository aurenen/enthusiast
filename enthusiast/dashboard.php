<?php
/*****************************************************************************
 Enthusiast: Listing Collective Management System
 Copyright (c) by Angela Sabas
 http://scripts.indisguise.org/

 Enthusiast is a tool for (fan)listing collective owners to easily
 maintain their listing collectives and listings under that collective.

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.

 For more information please view the readme.txt file.
******************************************************************************/
session_start();
require_once( 'logincheck.inc.php' );
if( !isset( $logged_in ) || !$logged_in ) {
   $_SESSION['message'] = 'You are not logged in. Please log in to continue.';
   $next = '';
   if( isset( $_SERVER['REQUEST_URI'] ) )
      $next = $_SERVER['REQUEST_URI'];
   else if( isset( $_SERVER['PATH_INFO'] ) )
      $next = $_SERVER['PATH_INFO'];
   $_SESSION['next'] = $next;
   header( 'location: index.php' );
   die( 'Redirecting you...' );
}

require_once( 'header.php' );
require( 'config.php' );
require_once( 'mod_categories.php' );
require_once( 'mod_joined.php' );
require_once( 'mod_owned.php' );
require_once( 'mod_affiliates.php' );
require_once( 'mod_settings.php' );
require_once( 'mod_errorlogs.php' );
?>

<h1>You are managing: <?php echo get_setting( 'collective_title' ) ?></h1>

<?php
$today = date( 'F j, Y (l)' );
if( date( 'a' ) == 'am' )
	$greeting = 'Good morning';
else {
	if( date( 'G' ) <= 18 )
		$greeting = 'Good afternoon';
	else
		$greeting = 'Good evening';
}
?>
<p><?php echo $greeting ?>! Today is <?php echo $today ?>.</p>

<h2>Collective statistics:</h2>

<?php
require_once( 'show_collective_stats.php' );
?>
<table class="stats">

<tr><td class="right">
Number of categories:
</td><td>
<?php echo $total_cats ?>
</td></tr>

<tr><td class="right">
Number of joined listings:
</td><td>
<?php echo $joined_approved ?> approved, <?php echo $joined_pending ?> pending
</td></tr>

<tr><td class="right">
Number of owned listings:
</td><td>
<?php echo $owned_current ?> current, <?php echo $owned_upcoming ?> upcoming, <?php echo $owned_pending ?> pending
</td></tr>

<tr><td class="right">
Number of collective affiliates:
</td><td>
<?php echo $affiliates_collective ?> affiliates
</td></tr>

<tr><td class="right">
Newest owned listing
</td><td>
<?php
if( count( $owned_newest ) > 0 ) {
?>
   <a href="<?php echo $owned_newest['url'] ?>"><?php echo $owned_newest['title']
   ?>: the <?php echo $owned_newest['subject'] ?> <?php echo $owned_newest['listingtype']
   ?></a>
<?php
} else echo 'None';
?>
</td></tr>

<tr><td class="right">
Newest joined listing
</td><td>
<?php
if( count( $joined_newest ) > 0 ) {
?>
   <a href="<?php echo $joined_newest['url'] ?>"><?php echo $joined_newest['subject'] ?></a>
<?php
} else echo 'None';
?>
</td></tr>

<tr><td class="right">
Total members in collective:
</td><td>
<?php echo $collective_total_fans_approved ?> (<?php echo $collective_total_fans_pending ?> pending)
</td></tr>

<tr><td class="right">
Collective members growth rate:
</td><td>
<?php echo $collective_fans_growth_rate ?> members/day
</td></tr>

</table>

<?php
$owned = get_owned( 'current' );
$header = true;
foreach( $owned as $id ) {
   $info = get_listing_info( $id );
   $stats = get_listing_stats( $id );

   // now check $lastupdated -- if more than 8 weeks ago, notify!
   $weeks = 0;
   $lastupdated = new DateTime($stats['lastupdated']);
   $currentdate = new DateTime();

   if( $stats['lastupdated'] == '' || // no last updated date
      $lastupdated->diff($currentdate, true)->days > 55 ) {
      if( $header ) {
?>
         <h2>Neglected Listings Notification</h2>
         <p>The following listings have gone on two months without a 
         newly-approved member or a new/updated affiliate!</p>
         <ul>
<?php
         $header = false;
      }
      // prepare date format
      $readable = @date( get_setting( 'date_format' ),
         strtotime( $stats['lastupdated'] ) );
      echo '<li> ';
      if( $info['title'] )
         echo $info['title'];
      else
         echo $info['subject'];
      echo ", last updated $readable;<br />manage ";
      echo '<a href="members.php?id=' . $info['listingid'] .
         '">members</a>';
      if( $info['affiliates'] == 1 ) // don't show if affiliates aren't enabled
         echo ' or <a href="affiliates.php?listing=' .
            $info['listingid'] . '">affiliates</a>';
      echo '?</li>';
   }
}
echo '</ul>';


require_once( 'footer.php' );
?>