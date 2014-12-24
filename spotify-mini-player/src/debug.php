<?php

// Turn off all error reporting
error_reporting(0);

// Load and use David Ferguson's Workflows.php class
require_once './src/workflows.php';
$w = new Workflows('com.vdesabou.spotify.mini.player');

$query = $argv[1];

if (mb_strlen($query) > 1) {
    $w->result(null, '', 'Exception occurred: ' . $query, 'Open issue with spot_mini_issue and send spot_mini_debug.tgz to the author (alfred.spotify.mini.player@gmail.com)', './images/warning.png', 'no', null, '');
}

exec("mkdir -p ~/Downloads/spot_mini_debug");

$output = "DEBUG: ";

//
// check for library update in progress
if (file_exists($w->data() . "/update_library_in_progress")) {
    $w->result('', '', "Library update in progress", "", 'fileicon:' . $w->data() . '/update_library_in_progress', 'no', null, '');
    $output = $output . "Library update in progress: " . "the file" . $w->data() . "/update_library_in_progress is present\n";
}

if (!file_exists($w->data() . "/settings.json")) {
    $output = $output . "The file" . $w->data() . "/settings.json is not present\n";
} else {
    copy($w->data() . "/settings.json", $w->home() . "/Downloads/spot_mini_debug/settings.json");
}

copy_directory($w->cache(), $w->home() . "/Downloads/spot_mini_debug/cache");

if (!file_exists($w->data() . "/library.db")) {
    $output = $output . "The file" . $w->data() . "/library.db is not present\n";
} else {
    copy($w->data() . "/library.db", $w->home() . "/Downloads/spot_mini_debug/library.db");
}


$output = $output . exec("uname -a");
$output = $output . "\n";
$output = $output . exec("sw_vers -productVersion");
$output = $output . "\n";
$output = $output . exec("sysctl hw.memsize");
$output = $output . "\n";


file_put_contents($w->home() . "/Downloads/spot_mini_debug/debug.log", $output);

exec("cd ~/Downloads;tar cfz spot_mini_debug.tgz spot_mini_debug");

$val = $w->home() . '/Downloads/spot_mini_debug.tgz';

$w->result(null, serialize(array(
    '' /*track_uri*/ ,
    '' /* album_uri */ ,
    '' /* artist_uri */ ,
    '' /* playlist_uri */ ,
    '' /* spotify_command */ ,
    '' /* query */ ,
    'Reveal▹' . $val /* other_settings*/ ,
    '' /* other_action */ ,
    '' /* alfred_playlist_uri */ ,
    '' /* artist_name */ ,
    '' /* track_name */ ,
    '' /* album_name */ ,
    '' /* track_artwork_path */ ,
    '' /* artist_artwork_path */ ,
    '' /* album_artwork_path */ ,
    '' /* playlist_name */ ,
    '' /* playlist_artwork_path */ ,
    '' /* $alfred_playlist_name */ ,
    '' /* now_playing_notifications */ ,
    '' /* is_alfred_playlist_active */ ,
    '' /* country_code*/ ,
    ''/* userid*/
)), 'Browse to generated tgz file', "This will reveal the tgz file in Finder", 'fileicon:' . $val, 'yes', null, '');


$w->result(null, '', 'Quick access to workflow folders:', '', './images/info.png', 'no', null, '');

$val = $w->data();


$w->result(null, serialize(array(
    '' /*track_uri*/ ,
    '' /* album_uri */ ,
    '' /* artist_uri */ ,
    '' /* playlist_uri */ ,
    '' /* spotify_command */ ,
    '' /* query */ ,
    'Open▹' . $val /* other_settings*/ ,
    '' /* other_action */ ,
    '' /* alfred_playlist_uri */ ,
    '' /* artist_name */ ,
    '' /* track_name */ ,
    '' /* album_name */ ,
    '' /* track_artwork_path */ ,
    '' /* artist_artwork_path */ ,
    '' /* album_artwork_path */ ,
    '' /* playlist_name */ ,
    '' /* playlist_artwork_path */ ,
    '' /* $alfred_playlist_name */ ,
    '' /* now_playing_notifications */ ,
    '' /* is_alfred_playlist_active */ ,
    '' /* country_code*/ ,
    ''/* userid*/
)), 'Browse to App Support Folder', "This will open the folder in Finder", 'fileicon:' . $val, 'yes', null, '');


$val = $w->cache();

$w->result(null, serialize(array(
    '' /*track_uri*/ ,
    '' /* album_uri */ ,
    '' /* artist_uri */ ,
    '' /* playlist_uri */ ,
    '' /* spotify_command */ ,
    '' /* query */ ,
    'Open▹' . $val /* other_settings*/ ,
    '' /* other_action */ ,
    '' /* alfred_playlist_uri */ ,
    '' /* artist_name */ ,
    '' /* track_name */ ,
    '' /* album_name */ ,
    '' /* track_artwork_path */ ,
    '' /* artist_artwork_path */ ,
    '' /* album_artwork_path */ ,
    '' /* playlist_name */ ,
    '' /* playlist_artwork_path */ ,
    '' /* $alfred_playlist_name */ ,
    '' /* now_playing_notifications */ ,
    '' /* is_alfred_playlist_active */ ,
    '' /* country_code*/ ,
    ''/* userid*/
)), 'Browse to Workflow Cache Folder', "This will open the folder in Finder", 'fileicon:' . $val, 'yes', null, '');


$val = exec('pwd');

$w->result(null, serialize(array(
    '' /*track_uri*/ ,
    '' /* album_uri */ ,
    '' /* artist_uri */ ,
    '' /* playlist_uri */ ,
    '' /* spotify_command */ ,
    '' /* query */ ,
    'Open▹' . $val /* other_settings*/ ,
    '' /* other_action */ ,
    '' /* alfred_playlist_uri */ ,
    '' /* artist_name */ ,
    '' /* track_name */ ,
    '' /* album_name */ ,
    '' /* track_artwork_path */ ,
    '' /* artist_artwork_path */ ,
    '' /* album_artwork_path */ ,
    '' /* playlist_name */ ,
    '' /* playlist_artwork_path */ ,
    '' /* $alfred_playlist_name */ ,
    '' /* now_playing_notifications */ ,
    '' /* is_alfred_playlist_active */ ,
    '' /* country_code*/ ,
    ''/* userid*/
)), 'Browse to Alfred workflow folder', "This will open the folder in Finder", 'fileicon:' . $val, 'yes', null, '');


echo $w->toxml();
function copy_directory($source, $destination)
{
    if (is_dir($source)) {
        @mkdir($destination);
        $directory = dir($source);
        while (FALSE !== ($readdirectory = $directory->read())) {
            if ($readdirectory == '.' || $readdirectory == '..') {
                continue;
            }
            $PathDir = $source . '/' . $readdirectory;
            if (is_dir($PathDir)) {
                copy_directory($PathDir, $destination . '/' . $readdirectory);
                continue;
            }
            copy($PathDir, $destination . '/' . $readdirectory);
        }

        $directory->close();
    } else {
        copy($source, $destination);
    }
}


?>