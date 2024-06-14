<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    private $dbFile;
    private $rooms = [];
    private $roomsFeatures;

    public function __construct(array $roomsFeatures = [])
    {
        parent::__construct();
        $this->roomsFeatures = $roomsFeatures;
    }

    public function readRoomsDatabase(string $datePicked)
    {
        $formatDate = explode("/", $datePicked);
        $this->dbFile = "{$formatDate[2]}-{$formatDate[1]}-{$formatDate[0]}_rooms_db.txt";

        if (!file_exists($this->dbFile)) {
            $fp = fopen($this->dbFile, "w");
            if ($fp === false) {
                throw new \Exception("Unable to open file for writing!");
            }
            foreach ($this->roomsFeatures as $roomId => $roomCapability) {
                fwrite($fp, "$roomId,$roomCapability\n");
            }
            fclose($fp);
        }

        clearstatcache();
        $fp = fopen($this->dbFile, 'r');
        if ($fp === false) {
            throw new \Exception("Unable to open file for reading!");
        }
        $this->rooms = explode("\n", fread($fp, filesize($this->dbFile)));
        fclose($fp);
    }

    public function writeRoomsDatabase(string $startTime, string $endTime, int $roomId)
    {
        $lines = file($this->dbFile);
        $new = '';
        if (is_array($lines)) {
            foreach ($lines as $line) {
                $data1room = explode(",", trim($line));
                if ($data1room[0] == $roomId) {
                    $new .= implode(",", $data1room) . ",$startTime,$endTime\n";
                } else {
                    $new .= "$line\n";
                }
            }
        }
        file_put_contents($this->dbFile, $new);
    }

    public function printRoomsDatabase(string $datePicked)
    {
        $this->readRoomsDatabase($datePicked);
        foreach ($this->rooms as $room) {
            if (!empty($room)) {
                $data1room = explode(",", $room);
                echo '<span class="badge bg-primary">Room ID: ' . $data1room[0] . '</span> ';
                echo '<span class="badge bg-secondary">Capacity: ' . $data1room[1] . '</span> ';
                for ($i = 2; $i < count($data1room); $i += 2) {
                    if (isset($data1room[$i + 1])) {
                        echo '<span class="badge rounded-pill bg-danger">' . $data1room[$i] . '-' . $data1room[$i + 1] . '</span>';
                    }
                }
                echo "<br>";
            }
        }
    }

    public function getOptimizedCapacityRoom(array $rooms, int $numCapacity): int
    {
        $bestTempRoomId = 0;
        $bestTempCapacity = PHP_INT_MAX;
        foreach ($rooms as $room) {
            if (!empty($room)) {
                $data1room = explode(",", $room);
                if ($this->checkRoomCapacity($room, $numCapacity) && $bestTempCapacity > $data1room[1]) {
                    $bestTempRoomId = $data1room[0];
                    $bestTempCapacity = $data1room[1];
                }
            }
        }
        return $bestTempRoomId;
    }

    private function checkRoomCapacity(string $room, int $numCapacity): bool
    {
        $data1room = explode(",", $room);
        return $data1room[1] >= $numCapacity;
    }

    private function compareHours(int $val, int $min, int $max): bool
    {
        return ($val > $min && $val < $max);
    }

    public function getAvailableRooms(string $startTime, string $endTime): array
    {
        $discard = false;
        $roomsOk = [];
        foreach ($this->rooms as $room) {
            if (!empty($room)) {
                $data1room = explode(",", $room);
                for ($i = 0; $i < (count($data1room) - 2) / 2; $i++) {
                    if ($this->compareHours(strtotime($startTime), strtotime($data1room[2 + (2 * $i)]), strtotime($data1room[3 + (2 * $i)]))
                        || $this->compareHours(strtotime($endTime), strtotime($data1room[2 + (2 * $i)]), strtotime($data1room[3 + (2 * $i)]))) {
                        $discard = true;
                    }
                }
                if (!$discard || (count($data1room) - 2) / 2 == 0) {
                    $roomsOk[] = $room;
                }
                $discard = false;
            }
        }
        return $roomsOk;
    }
}
