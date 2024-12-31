<?php

namespace BPL\Mods\Upload_Image;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Url_SEF\sef;

/**
 * @param           $id
 *
 * @param           $avatar
 * @param string $type repeat || incentive
 *
 * @since version
 */
function main($id, $avatar, string $type = 'repeat')
{
    if ($avatar['name'] !== '') {
        $app = application();

        $db = db();

        $max = $app->get('max_size_upload', 3200000);

        $file_type = ['image/jpeg', 'image/gif', 'image/png'];
        $userFolder = 'images/' . $type;

        jimport('joomla.filesystem.file');

        $msg = '';

        if (!file_exists($userFolder)) {
            Folder::create($userFolder, 775);
        }

        $filename = $id . '.' . substr(File::makeSafe($avatar['name']), -3);

        $src = $avatar['tmp_name'];

        //Set up the source and destination of the file
        $dest = 'images/' . $type . '/' . $filename;

        if ($avatar['size'] > $max) {
            $msg .= Text::_('Only file under') . ' ' . $max . ' kbs accepted.';
        }

        if ($avatar['size'] <= $max) {
            //First check if the file has the right extension, we need image type only
            if (in_array($avatar['type'], $file_type, true)) {
                if (File::upload($src, $dest)) {
                    update(
                        $type === 'p2p' ? 'network_p2p_items' : 'network_items_' . $type,
                        ['picture = ' . $db->quote($filename)],
                        [($type !== 'merchant' ? 'item_id = ' : 'merchant_id = ') . $db->quote($id)]
                    );
                } else {
                    //Redirect and throw an error message
                    $msg .= Text::_('Upload failed.');
                }
            } else {
                //Redirect and notify user file is not right extension
                $msg .= Text::_('File type invalid.');
            }

            $sef = 69;

            switch ($type) {
                case 'repeat':
                    $sef = 69;
                    break;
                case 'merchant':
                    $sef = 123;
                    break;
                case 'incentive':
                    $sef = 50;
                    break;
                case 'p2p':
                    $sef = 126;
                    break;
            }

            if ($msg !== '') {
                $app->redirect(Uri::root(true) . '/' . sef($sef), $msg, 'error');
            }

            //resize
            $nw = 200;    //New Width
            $nh = 200;    //new Height

            $source = 'images/' . $type . '/' . $filename;    //Source file
            $dest = 'images/' . $type . '/tmb_' . $filename;

            $stype = explode('.', $source);
            $stype = $stype[count($stype) - 1];

            $size = getimagesize($source);

            [$w, $h] = $size;

            $simg = 0;

            switch ($stype) {
                case 'gif':
                    $simg = imagecreatefromgif($source);
                    break;
                case 'jpg':
                    $simg = imagecreatefromjpeg($source);
                    break;
                case 'png':
                    $simg = imagecreatefrompng($source);
                    break;
            }

            $dimg = imagecreatetruecolor($nw, $nh);

            imagefilledrectangle($dimg, 0, 0, $nw, $nh, imagecolorallocate($dimg, 255, 255, 255));

            $wm = $w / $nw;
            $hm = $h / $nh;
            $h_height = $nh / 2;
            $w_height = $nw / 2;

            if ($w > $h) {
                $adjusted_width = $w / $hm;
                $half_width = $adjusted_width / 2;
                $int_width = $half_width - $w_height;

                imagecopyresampled(
                    $dimg,
                    $simg,
                    -$int_width,
                    0,
                    0,
                    0,
                    $adjusted_width,
                    $nh,
                    $w,
                    $h
                );
            } elseif (($w < $h) || ($w === $h)) {
                $adjusted_height = $h / $wm;
                $half_height = $adjusted_height / 2;
                $int_height = $half_height - $h_height;

                imagecopyresampled(
                    $dimg,
                    $simg,
                    0,
                    -$int_height,
                    0,
                    0,
                    $nw,
                    $adjusted_height,
                    $w,
                    $h
                );
            } else {
                imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
            }

            imagejpeg($dimg, $dest, 80);
        }
    }
}