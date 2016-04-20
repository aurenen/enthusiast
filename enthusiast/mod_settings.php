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

/*___________________________________________________________________________*/
function get_setting( $setting ) {
   include 'config.php';

   /*$query = "SELECT `value` FROM `$db_settings` WHERE `setting` = '$setting'";

   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT `value` FROM `$db_settings` WHERE `setting` = ?";

   $stmt = $db_link->prepare($query);
   if (!$stmt) 
     fail('MySQL get_setting prepare', $stmt->error);
   if (!$stmt->bind_param('s', $setting))
     fail('MySQL get_setting bind_param', $stmt->error);
   if (!$stmt->execute())
     fail('MySQL get_setting execute', $stmt->error);
   if (!$stmt->store_result())
     fail('MySQL get_setting store_result', $stmt->error);
   if (!$stmt->bind_result($value))
     fail('MySQL get_setting bind_result', $stmt->error);
   if (!$stmt->fetch() && $stmt->errno)
     fail('MySQL get_setting fetch', $stmt->error);

   /* $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }
   $row = mysqli_fetch_array( $result );
   return $row['value'];*/
   $db_link->close();
   return $value;

} // end of get_setting


/*___________________________________________________________________________*/
function check_password( $password ) {
   include 'config.php';

   /*$query = "SELECT * FROM `$db_settings` WHERE `setting` = 'password' AND ";
   $query .= "`value` = '$password'";

   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );
   $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT * FROM `$db_settings` WHERE `setting` = 'password' AND `value` = ?";
   $stmt = $db_link->prepare($query);
   $stmt->bind_param('s', $password);
   $stmt->execute();
   $stmt->store_result();

   if ($stmt->num_rows > 0) {
      $stmt->close();
      $db_link->close();
      return true;
   }
   else
      return false;
}


/*___________________________________________________________________________*/
function get_setting_title( $setting ) {
   include 'config.php';

   /*$query = "SELECT `title` FROM `$db_settings` WHERE `setting` = '$setting'";
   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );
   $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }
   $row = mysqli_fetch_array( $result );
   return $row['title'];*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT `title` FROM `$db_settings` WHERE `setting` = ?";

   $stmt = $db_link->prepare($query);
   if (!$stmt) 
     fail('MySQL get_setting_title prepare', $stmt->error);
   if (!$stmt->bind_param('s', $setting))
     fail('MySQL get_setting_title bind_param', $stmt->error);
   if (!$stmt->execute())
     fail('MySQL get_setting_title execute', $stmt->error);
   if (!$stmt->store_result())
     fail('MySQL get_setting_title store_result', $stmt->error);
   if (!$stmt->bind_result($title))
     fail('MySQL get_setting_title bind_result', $stmt->error);
   if (!$stmt->fetch() && $stmt->errno)
     fail('MySQL get_setting_title fetch', $stmt->error);

   $db_link->close();
   return $title;
} // end of get_setting_title


/*___________________________________________________________________________*/
function get_setting_desc( $setting ) {
   include 'config.php';

   /*$query = "SELECT `help` FROM `$db_settings` WHERE `setting` = '$setting'";
   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );
   $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }
   $row = mysqli_fetch_array( $result );
   return $row['help'];*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT `help` FROM `$db_settings` WHERE `setting` = ?";
   $stmt = $db_link->prepare($query);
   if (!$stmt) 
     fail('MySQL get_setting_desc prepare', $stmt->error);
   if (!$stmt->bind_param('s', $setting))
     fail('MySQL get_setting_desc bind_param', $stmt->error);
   if (!$stmt->execute())
     fail('MySQL get_setting_desc execute', $stmt->error);
   if (!$stmt->bind_result($help))
     fail('MySQL get_setting_desc bind_result', $stmt->error);
   if (!$stmt->fetch() && $stmt->errno)
     fail('MySQL get_setting_desc fetch', $stmt->error);

   $db_link->close();
   return $help;
} // end of get_setting_desc


/*___________________________________________________________________________*/
function get_all_settings() {
   include 'config.php';

   /*$query = "SELECT * FROM `$db_settings` WHERE `setting` " .
      "NOT LIKE '%template%'";
   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );
   $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }

   $settings = array();
   while( $row = mysqli_fetch_array( $result ) )
      $settings[] = $row;
   return $settings;*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT * FROM `$db_settings` WHERE `setting` NOT LIKE '%template%'";
   $stmt = $db_link->prepare($query);

   if (!$stmt) 
     fail('MySQL get_all_settings prepare', $stmt->error);
   if (!$stmt->execute())
     fail('MySQL get_all_settings execute', $stmt->error);
   if (!$stmt->store_result())
     fail('MySQL get_all_settings store_result', $stmt->error);
   $meta = $stmt->result_metadata(); 

   while ($field = $meta->fetch_field()) { 
     $params[] = &$row[$field->name]; 
   } 

   call_user_func_array(array($stmt, 'bind_result'), $params);            
   while ($stmt->fetch()) { 
     foreach($row as $key => $val) { 
         $c[$key] = $val * $level; 
     } 
     $setting_list = $c; 
   } 
   $stmt->close(); 
   $db_link->close();
   return $setting_list;

} // end of get_all_settings


/*___________________________________________________________________________*/
function get_all_templates() {
   include 'config.php';

   /*$query = "SELECT * FROM `$db_settings` WHERE `setting` LIKE '%template%'";
   $db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );
   $result = mysqli_query( $db_link, $query );
   if( !$result ) {
      log_error( __FILE__ . ':' . __LINE__,
         'Error executing query: <i>' . mysqli_error($db_link) .
         '</i>; Query is: <code>' . $query . '</code>' );
      die( STANDARD_ERROR );
   }
   $templates = array();
   while( $row = mysqli_fetch_array( $result ) )
      $templates[] = $row;
   return $templates;*/

   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   $query = "SELECT * FROM `$db_settings` WHERE `setting` LIKE '%template%'";
   $stmt = $db_link->prepare($query);

   if (!$stmt) 
     fail('MySQL get_all_templates prepare', $stmt->error);
   if (!$stmt->execute())
     fail('MySQL get_all_templates execute', $stmt->error);
   if (!$stmt->store_result())
     fail('MySQL get_all_templates store_result', $stmt->error);
   $meta = $stmt->result_metadata(); 

   while ($field = $meta->fetch_field()) { 
     $params[] = &$row[$field->name]; 
   } 

   call_user_func_array(array($stmt, 'bind_result'), $params);            
   while ($stmt->fetch()) { 
     foreach($row as $key => $val) { 
         $c[$key] = $val * $level; 
     } 
     $template_list = $c; 
   } 
   $stmt->close(); 
   $db_link->close();
   return $template_list;
} // end of get_all_settings


/*___________________________________________________________________________*/
function update_setting( $setting, $value ) {
   include 'config.php';

   /*$db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
      or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );

   if( $setting != 'password' ) {
      $query = "UPDATE `$db_settings` SET `value` = '$value' WHERE " .
         "`setting` = '$setting'";
      $result = mysqli_query( $db_link, $query );
      if( !$result ) {
         log_error( __FILE__ . ':' . __LINE__,
            'Error executing query: <i>' . mysqli_error($db_link) .
            '</i>; Query is: <code>' . $query . '</code>' );
         die( STANDARD_ERROR );
      }
   } else {
      $query = "UPDATE `$db_settings` SET `value` = MD5( '$value' ) " .
         "WHERE `setting` = 'password'";
      $result = mysqli_query( $db_link, $query );
      if( !$result ) {
         log_error( __FILE__ . ':' . __LINE__,
            'Error executing query: <i>' . mysqli_error($db_link) .
            '</i>; Query is: <code>' . $query . '</code>' );
         die( STANDARD_ERROR );
      }
   }*/
   $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
   if ($db_link->connect_errno > 0) {
      die('Unable to connect to database [' . $db_link->connect_error . ']');
   }
   if( $setting != 'password' ) {
      $query = "UPDATE `$db_settings` SET `value` = ? WHERE `setting` = ?";
      $stmt = $db_link->prepare($query);
      if (!$stmt) 
        fail('MySQL update_setting prepare', $stmt->error);
      if (!$stmt->bind_param('ss', $value, $setting))
        fail('MySQL update_setting bind_param', $stmt->error);
      if (!$stmt->execute())
        fail('MySQL update_setting execute', $stmt->error);
      if (!$stmt->store_result())
        fail('MySQL update_setting store_result', $stmt->error);
      $stmt->close();
   } else {
      $query = "UPDATE `$db_settings` SET `value` = MD5( ? ) WHERE `setting` = 'password'";
      $stmt = $db_link->prepare($query);
      if (!$stmt) 
        fail('MySQL update_setting password prepare', $stmt->error);
      if (!$stmt->bind_param('ss', $value, $setting))
        fail('MySQL update_setting password bind_param', $stmt->error);
      if (!$stmt->execute())
        fail('MySQL update_setting password execute', $stmt->error);
      $stmt->close();
   }
   $db_link->close();
} // end of update_setting


/*___________________________________________________________________________*/
function update_settings( $settings ) {
  include 'config.php';
  $msg = '';
  /*$db_link = mysqli_connect( $db_server, $db_user, $db_password, $db_database )
    or die( DATABASE_CONNECT_ERROR . mysqli_error($db_link) );

  foreach( $settings as $field => $value ) {
    $query = "UPDATE `$db_settings` SET `value` = '$value' WHERE " .
       "`setting` = '$field'";
    if( $field == 'password' ) {
       if( $settings['passwordv'] != '' &&
          $value == $settings['passwordv'] ) {
          $query = "UPDATE `$db_settings` SET `value` = MD5( '$value' ) " .
             "WHERE `setting` = 'password'";
       } else
          $query = '';
    }
    if( $query != '' ) {
       $result = mysqli_query( $db_link, $query );
       if( !$result ) {
          log_error( __FILE__ . ':' . __LINE__,
             'Error executing query: <i>' . mysqli_error($db_link) .
             '</i>; Query is: <code>' . $query . '</code>' );
          die( STANDARD_ERROR );
       }
    }
  }*/
  $db_link = new mysqli( $db_server, $db_user, $db_password, $db_database );
  if ($db_link->connect_errno > 0) {
    die('Unable to connect to database [' . $db_link->connect_error . ']');
  }
  foreach( $settings as $field => $value ) {
    if( $field == 'password' ) {
      if( $settings['passwordv'] != '' && $value == $settings['passwordv'] ) {
        $query = "UPDATE `$db_settings` SET `value` = MD5( ? ) " .
          "WHERE `setting` = 'password'";
        $stmt = $db_link->prepare($query);
        if (!$stmt) 
          fail('MySQL update_setting prepare', $stmt->error);
        if (!$stmt->bind_param('s', $value))
          fail('MySQL update_setting bind_param', $stmt->error);
        if (!$stmt->execute())
          fail('MySQL update_setting execute', $stmt->error);
        if (!$stmt->store_result())
          fail('MySQL update_setting store_result', $stmt->error);
        $stmt->close();
      } 
    }
    elseif( $field != 'passwordv' ) {
      $query = "UPDATE `$db_settings` SET `value` = ? WHERE `setting` = ?";
      $stmt = $db_link->prepare($query);
      if (!$stmt) 
        fail('MySQL update_setting prepare', $stmt->error);
      if (!$stmt->bind_param('ss', $value, $field))
        fail('MySQL update_setting bind_param', $stmt->error);
      if (!$stmt->execute()) 
        fail('MySQL update_setting execute', $stmt->error);
      if (!$stmt->store_result()) 
        fail('MySQL update_setting store_result', $stmt->error);
      $stmt->close();
    }
  }
  $db_link->close();
}