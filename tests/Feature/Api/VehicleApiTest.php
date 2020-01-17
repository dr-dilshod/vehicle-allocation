<?php

namespace Tests\Feature\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class VehicleApiTest
 * @package Tests\Feature\Feature\Api
 * @author Dilshod K
 */
class VehicleApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Acquisition data: Car rental master.Car rental company (DISTINCT)
     */
    public function testDataAcquisition()
    {

    }
    /**
     * Search condition: Rental vehicle master. Delete flag	= 0
     */
    public function testSearchCondition()
    {

    }

    /**
     * Display order: Rental vehicle master. Rental car No. ascending order
     */
    public function testDisplayOrder()
    {

    }

    /**
    * Acquisition data: Rental vehicle master Rental vehicle No.
    */
    public function testRentalVehicleNo()
    {

    }

    /**
    * Acquisition data: Rental vehicle master. Rental vehicle company name
    */
    public function testVehicleCompanyName()
    {

    }

    /**
    * Acquisition data: Rental vehicle master. Furigana (company name)
    */
    public function testFuriganaCompanyName()
    {

    }

    /**
    * Acquisition data: Rental vehicle master.
    */
    public function testVehicleMaster()
    {

    }

    /**
     * Acquisition data: Rental vehicle master.Postal code
     */
    public function testPostalCode()
    {

    }

    /**
     * Acquisition data: Rental vehicle master. Address 1
     */
    public function testAddress1()
    {

    }

    /**
     * Acquisition data: Charter Master. Address 2
     */
    public function testAddress2()
    {

    }

    /**
     * Acquisition data: Rental vehicle master.Phone number
     */
    public function testPhoneNumber()
    {

    }

    /**
     * Acquisition data: Rental vehicle master.FAX number
     */
    public function testFAXNumber()
    {

    }

    /**
     * Acquisition data: Search condition: Rental vehicle master. Delete flag = 0
     */
    public function testDeleteFlag()
    {

    }

    /**
     * Acquisition data: Display order: Rental vehicle master. Rental car No.
     */
    public function testRentalCarNo()
    {

    }

    /**
     * 2-1. When the edit button is pressed: Display "Editing" and enter edit mode.
     */

    /**
     * When the edit button is pressed: 2-2. Activate the “Register” button.
     */


    /**
     * 3. When the search button is pressed: Acquisition data: Rental vehicle master Rental vehicle No.
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master. Rental car company name
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master. Furigana (company name)
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.Postal code
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master. Address 1
     */
    /**
     * 3. When the search button is pressed: Acquisition data: Charter Master. Address 2
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.Phone number
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.FAX number
     */

    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.
     */
    /**
     * 3. When the search button is pressed: Acquisition data: Rental car master.
     */
    /**
     * 3. When the search button is pressed: Search condition:
     * Rental car master. Rental car company name= Rental car company.Select box
     */

    /**
     * 3. When the search button is pressed: Search condition:
     * Rental car master. Delete flag = 0
     */
    /**
     * 3. When the search button is pressed: Display order
     * Rental car master. Rental car No.
     */

    /**
     * 4. When the clear button is pressed:
     * 4-1. Leave the following search condition items blank.
     * Rental car company.Select box
     */

    /**
     * 5. When the registration button is pressed:
     * 5-1. Input check
     * Indispensable check If the charter vehicle number or charter company name is not entered
     * Message ID						｛0｝						Message
     * MSG07						Merchant vehicle No				Please enter {0}
     */


    /**
     * 5. When the registration button is pressed:
     * 5-1. Input check
     * Indispensable check If the charter vehicle number or charter company name is not entered
     * Message ID						｛0｝						Message
     * MSG07						Rental car company name			Please enter {0}.
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental vehicle master Rental vehicle No.	=	Merchant vehicle number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Rental car company name = Car rental company name.text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Furigana (company name) =	 Furigana (company name). Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. =	 Abbreviation: text box
     */
    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Postal code = Postcode or text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Address 1 = Address 1. Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Charter Master. Address 2 = Address 2. Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Phone number = Phone number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.FAX number = Fax number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = Offset.text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = Remarks: text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Updater ID = Update user
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = TODAY
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update condition
     * Rental car master. Rental car ID = Selection data.Car rental ID
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update condition
     * A pop-up is displayed as three common specifications, and the edit mode ends.
     */




    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Rental car IDautomatic numbering
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental vehicle master Rental vehicle No. = Merchant vehicle number text box
     */

     /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Rental car company name = Car rental company name.text box
     */

    /** 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Furigana (company name) = Furigana (company name). Text box
     */

    /**  5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Abbreviation: text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Postal code = Postcode or text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Address 1 = Address 1. Text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Charter Master. Address 2 = Address 2. Text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Phone number = Phone number text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.FAX number = Fax number text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Offset.text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Remarks: text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list
     * ・ Update data
     * Rental car master, registrant ID = Update user
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = TODAY
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Updater ID = Update user
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = TODAY
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * A pop-up is displayed as three common specifications, and the edit mode ends.
     */

}