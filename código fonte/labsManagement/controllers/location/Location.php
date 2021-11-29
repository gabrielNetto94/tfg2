<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class Location
{
    var $setBuilding;
    var $building;
    var $room;

    function Location($setBuilding, $building, $room)
    {
        $this->setBuilding = $setBuilding;
        $this->building = $building;
        $this->room = $room;
    }

    public static function Create($location)
    {

        $query = "
        INSERT INTO [dbo].[LOCATION]([SET_BUILDING],[BUILDING],[ROOM])
            VALUES ($location->setBuilding,$location->building,'$location->room')";

        try {

            $pdo = Database::getConnection();
            $smt = $pdo->prepare($query);

            if ($smt->execute()) {

                return $pdo->lastInsertId();
            };
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Update($idLocation, $location)
    {
        $query = " UPDATE LOCATION
                SET [SET_BUILDING] = $location->setBuilding,[BUILDING] = $location->building,[ROOM] = '$location->room'
                WHERE ID_LOCATION = $idLocation ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetHistoryLab($idLab)
    {
        $query="
        select lh.SET_BUILDING,lh.BUILDING, lh.ROOM, LOG_DATE from LOCATION_HISTORY  lh
        join lab  on lab.FK_ID_LOCATION = lh.FK_ID_LOCATION
        where lab.ID_LAB = $idLab
        order by LOG_DATE desc
        ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
}
