<?php

class BookingController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        $userSession = new UserSession();

        if($userSession->IsAuthenticated('User',$_SESSION) == false)
        {
            $http->redirectTo('/user/login');
        }

        return
        [
            'userId' => $userSession->GetData('Id')
        ];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        $bookingModel = new BookingModel();


        $bookingDate = $formFields['Booking-Year'].'-'.$formFields['Booking-Month'].'-'.$formFields['Booking-Day'];

        $bookingTime = $formFields['Booking-Hours'].':'.$formFields['Booking-Minutes'];

        $bookingModel->createBooking
            (
                $formFields['UserId'],
                $bookingDate,
                $bookingTime,
                $formFields['Booking-Table']
            );

        $http->redirectTo('/?success=ok&what=booking');
    }
}