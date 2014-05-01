<?php
/**
 * Copyright (c) 2014, Marcel Hauri
 * All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright Copyright 2014, Marcel Hauri (https://github.com/mhauri/Mhauri_LogView/)
 *
 * @category Logging
 * @package Mhauri_LogView
 * @author Marcel Hauri <marcel@hauri.me>
 */

class Mhauri_LogView_Block_Adminhtml_List extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::_construct();
        $this->setTemplate('logview/list.phtml');
    }

    /**
     * get all log files out of /var/log and return an array with additional information
     *
     * @return array
     */
    protected function getLogFiles()
    {
        $files = array();
        $logPath = Mage::getBaseDir('log');

        foreach(glob($logPath . DIRECTORY_SEPARATOR . '*.log') as $file) {
            $info    = pathinfo($file);
            $size    = filesize($file);
            $changed = filemtime($file);
            $files[] = array(
                'id'             => $info['filename'],
                'name'           => $info['basename'],
                'readable'       => is_readable($file),
                'changed'        => $changed,
                'changed_human'  => Mage::helper('core')->formatDate(date('c', $changed), 'long', true),
                'filesize'       => $size,
                'filesize_human' => $this->_getNiceFileSize($size));
        }
        return $files;
    }

    /**
     * Returns human readable file size
     *
     * @param $file
     * @return string
     */
    protected function _getNiceFileSize($item)
    {
        if(is_numeric($item)) {
            $f = $item;
        } else {
            $f = filesize($item);
        }

        $s = "Byte";
        if ($f > 1023) {
            $f = round(($f/1024),2);
            $s = "KB";

            if ($f > 1023) {
                $f = round(($f/1024),2);
                $s = "MB";

                if ($f > 1023) {
                    $f = round(($f/1024),2);
                    $s = "GB";
                }
            }
        }
        return $f . " " . $s;
    }
}
