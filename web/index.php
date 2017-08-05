<?php
require_once __DIR__ . '/../vendor/autoload.php';

use src\components\BoardingCardsProcessor;
use src\components\BasicBoardingCardsSort;
use src\components\BoardingCardsConverter;

/**
 * This API requires 3 params
 * cards - JSON list with attributes:
 *  type(required) - Can be plane, train, bus
 *  startPoint(required) - Start point, e.g. Equador
 *  endPoint(required) - End point, e.g. Dakka,
 *  number(required) - Race number, e.g. "22122BD",
 *  seat - Seat number, e.g "22"
 *  baggageNumber - Baggage number, e.g 1A
 * start - Point, from which trip starts,
 * end - Point where trip ends
 *
 * So, request to API should look like this
 * "cards" :[
 *       {
 *       "type": "plane",
 *       "startPoint": "Equador",
 *       "endPoint": "Kuta",
 *       "number": "A23DC",
 *       "gate": "10F",
 *       "seat": "11B",
 *       "baggageNumber": ""
 *       },
 *       {
 *       "type": "plane",
 *       "startPoint": "Dakka",
 *      "endPoint": "Equador",
 *      "number": "A23DC",
 *       "gate": "10F",
 *       "baggageNumber": ""
 *       }],
 * "start": "Dakka",
 * "end": "Kuta"
 */
if (isset($_POST['cards'], $_POST['start'], $_POST['end'])) {
    //Convert cards from json to list of Transport objects
    $cardsList = BoardingCardsConverter::getTransportListFromJson($_POST['cards']);

    //Sort the cards
    $boardingCardsProcessor = new BoardingCardsProcessor();
    $boardingCardsProcessor->addCards($cardsList);
    $res = $boardingCardsProcessor->getSortedList(new BasicBoardingCardsSort(), $_POST['start'], $_POST['end']);

    //Base on sorted cards, get list of description
    $dm = new \src\components\DescriptionManager();
    $dm->addBoardingCards($res);

    //View the list in JSON format
    echo json_encode($dm->getListWithDescriptions());
}

