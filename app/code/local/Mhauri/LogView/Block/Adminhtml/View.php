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

class Mhauri_LogView_Block_Adminhtml_View extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::_construct();
        $this->setTemplate('logview/view.phtml');
    }

    /**
     * Get the name of the logfile based on the parameter
     *
     * @return string
     */
    protected function getLogName()
    {
        return $this->getRequest()->getParam('log') . Mhauri_LogView_Helper_Data::LOG_FILE_DEFAULT_ENDING;
    }

    /**
     * Returns the content of the logfile if it exists
     *
     * @return bool
     */
    protected function getLogContent()
    {
        $lines = ($this->getRequest()->getParam('limit')) ? intval($this->getRequest()->getParam('limit')) : Mhauri_LogView_Helper_Data::LOG_FILE_DEFAULT_LINES;

        if($file = $this->isLogFileExisting()) {
            passthru("tail -n " . $lines . " " . $file);
        }
        return false;
    }

    /**
     * Checks if the requested logfile exists and returns the file path
     *
     * @return bool|string
     */
    protected function isLogFileExisting()
    {
        $logPath = Mage::getBaseDir('log');
        if($file = realpath($logPath . DIRECTORY_SEPARATOR . $this->getLogName())) {
            return $file;
        }
        return false;
    }
}
