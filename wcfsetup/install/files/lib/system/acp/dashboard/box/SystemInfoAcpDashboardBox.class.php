<?php

namespace wcf\system\acp\dashboard\box;

use wcf\system\WCF;

/**
 * ACP dashboard box that shows system information.
 *
 * @author      Marcel Werk
 * @copyright   2001-2023 WoltLab GmbH
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
final class SystemInfoAcpDashboardBox extends AbstractAcpDashboardBox
{
    public function getTitle(): string
    {
        return WCF::getLanguage()->get('wcf.acp.dashboard.box.systemInfo');
    }

    public function getContent(): string
    {
        return WCF::getTPL()->fetch('systemInfoAcpDashboardBox', 'wcf', $this->getVariables());
    }

    private function getVariables(): array
    {
        return [
            'databaseName' => $this->getDatabaseName(),
            'server' => $this->getServerInfo(),
        ];
    }

    private function getDatabaseName(): string
    {
        $sql = "SELECT DATABASE()";
        $statement = WCF::getDB()->prepare($sql);
        $statement->execute();
        return $statement->fetchSingleColumn();
    }

    private function getServerInfo(): array
    {
        return [
            'os' => \PHP_OS,
            'webserver' => $_SERVER['SERVER_SOFTWARE'] ?? '',
            'mySQLVersion' => WCF::getDB()->getVersion(),
            'load' => $this->getLoad(),
            'memoryLimit' => \ini_get('memory_limit'),
            'upload_max_filesize' => \ini_get('upload_max_filesize'),
            'postMaxSize' => \ini_get('post_max_size'),
            'innodbFlushLogAtTrxCommit' => $this->getInnodbFlushLogAtTrxCommit(),
        ];
    }

    private function getInnodbFlushLogAtTrxCommit(): int
    {
        $sql = "SELECT @@innodb_flush_log_at_trx_commit";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();
        return $statement->fetchSingleColumn();
    }

    private function getLoad(): string
    {
        if (\function_exists('sys_getloadavg')) {
            $load = \sys_getloadavg();
            if (\is_array($load) && \count($load) == 3) {
                return \implode(
                    ', ',
                    \array_map(static function (float $value) {
                        return \sprintf('%.2F', $value);
                    }, $load)
                );
            }
        }

        return '';
    }
}
