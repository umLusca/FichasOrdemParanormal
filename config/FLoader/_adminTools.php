<?php


function checkProcesses(false|string $videoId = false): bool
{
    global $_CONFIG;
    getProcesses($running);
    if (!apcu_fetch("STOP")) {
        if (is_array($running) && count($running) >= $_CONFIG["numProcessos"]) {
            if ($videoId) apcu_store("p_" . $videoId, "waiting", 15);
            return false;
        }
        if ($videoId) apcu_store("p_" . $videoId, "processing", 15);
        return true;
    }

    exit(500);

}

function getProcesses(&$processing = [], &$waiting = [], &$completed = [])
{

    $apcu = apcu_cache_info();
    $runners = [];


    $realwaiting = [];
    foreach ($apcu["cache_list"] as $i => $v) {
        $val = apcu_fetch($v["info"]);
        if (empty($val) && $val !== 0 && $val !== []) {
            apcu_delete($v["info"]);
        } else {

            if (str_starts_with($v["info"], "p_")) {

                $realwaiting[substr($v["info"], 2)] = $val;
                $t = substr($v["info"], 2);
                if ($val === "completed") {
                    ${$val}[$t] = apcu_fetch("t_" . $t);

                } else
                    if ($val === "processing") {

                        ${$val}[$t] = apcu_fetch("%_" . $t);

                    } else {

                        ${$val}[] = $t;
                    }

            }


        }
    }
    return $realwaiting;
}


function getSymbolByQuantity($bytes, bool $returnUnit = true)
{
    $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $exp = floor(log($bytes) / log(1024));

    return $returnUnit ? sprintf('%.2f ' . $symbols[$exp], ($bytes / (1024 ** floor($exp)))):(float)($bytes / (1024 ** floor($exp)));
}

function _getServerLoadLinuxData()
{
    if (is_readable("/proc/stat")) {
        $stats = @file_get_contents("/proc/stat");

        if ($stats !== false) {
            // Remove double spaces to make it easier to extract values with explode()
            $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

            // Separate lines
            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
            $stats = explode("\n", $stats);

            // Separate values and find line for main CPU load
            foreach ($stats as $statLine) {
                $statLineData = explode(" ", trim($statLine));
                // Found!
                if ((count($statLineData) >= 5) && ($statLineData[0] == "cpu")) {
                    return array(
                        $statLineData[1],
                        $statLineData[2],
                        $statLineData[3],
                        $statLineData[4],
                    );
                }
            }
        }
    }

    return null;
}

function getServerLoad()
{
    $load = null;
    if (is_readable("/proc/stat")) {
        // Collect 2 samples - each with 1 second period
        // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
        $statData1 = _getServerLoadLinuxData();
        $statData2 = _getServerLoadLinuxData();

        if ((!is_null($statData1))) {
            // Get difference
            $statData2[0] -= $statData1[0];
            $statData2[1] -= $statData1[1];
            $statData2[2] -= $statData1[2];
            $statData2[3] -= $statData1[3];

            // Sum up the 4 values for User, Nice, System and Idle and calculate
            // the percentage of idle time (which is part of the 4 values!)
            $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

            // Invert percentage to get CPU time, not idle time
            $cpuTime = max($cpuTime,1);
            $load = 100 - ($statData2[3] * 100 / $cpuTime);
        }
    }


    return $load;
}
