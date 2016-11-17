<?php

class BookingModel
{
    public function createBooking($userId,$bookingDate,$bookingTime,$tableSize)
    {
        $database = new Database();

        $sql = 'INSERT INTO Booking(User_Id,BookingDate,BookingTime,TableSize,CreationTimestamp)
                VALUES (?,?,?,?,now())';

        $values=
            [
                $userId,
                $bookingDate,
                $bookingTime,
                $tableSize
            ];

        $database->executeSql($sql,$values);
    }
}