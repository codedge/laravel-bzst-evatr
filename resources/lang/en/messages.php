<?php

return [
    '200' => 'The requested VAT ID is valid.',
    '201' => 'The requested VAT ID is invalid.',
    '202' => 'The requested VAT ID is invalid. It is not registered in the EU member state.
              Note: Your business partner can request its valid VAT ID at the responsible Ministry of Finance responsible.',
    '203' => 'The requested VAT ID is invalid. It is valid from ... - please see the "Valid from" field.',
    '204' => 'The requested VAT ID is invalid. It was valid between ... and ... (please check fields "valid from" and "valid until").',
    '205' => 'Your request cannot  be processed by the EU member or due to other reasons. Please try again later. If problems persist please contact the Federal Central Tax Office.',
    '206' => 'Your German VAT ID is invalid. Therefore your request cannot be processed. Please contact the Federal Central Tax Office.',
    '207' => 'Your German VAT ID is only valid for taxation of intra-Community acquisitions. You are not permitted to file any requests.',
    '208' => 'There is already a request running for the VAT ID requested by you. Your request cannot be processed. Please try again later.',
    '209' => 'The requested VAT ID is invalid. It does not comply with the format of that EU member state.',
    '210' => 'The requested VAT ID is invalid. It does not comply with the checksum rules of that EU member state.',
    '211' => 'The requested VAT ID is invalid. It contains invalid characters (i. e. spaces, dashes etc.).',
    '212' => 'The requested VAT ID is invalid. It contains an invalid country code.',
    '213' => 'A German VAT ID cannot be requested.',
    '214' => 'Your German VAT ID is invalid. It starts with "DE" followed by 9 digits.',
    '215' => 'Your request does not contain all necessary data for a qualified request. Your request cannot be processed.',
    '216' => 'Your request does not contain all necessary data for a qualified request. A simple request has been made instead with the following result: The requested VAT ID is valid.',
    '217' => 'While processing the data from the EU member state an error occured. Your request cannot be processed.',
    '218' => 'A qualified request is currently not possible. A simple request has been made instead with the following result: The requested VAT ID is valid.',
    '219' => 'While running a qualified request an error occured. A simple request has been made instead with the following result: The requested VAT ID is valid.',
    '220' => 'When requesting an official confirmation an error occured. No official confirmation will be sent.',
    '221' => 'The requested data does not contain all necessary parameters or an illegal data type. Please check the documentation how to call the interface.',
    '999' => 'The request cannot be processed at the moment. Please try later again.',
];
