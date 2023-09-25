<?php


namespace App\UseCases;

use DateTime;
use phpDocumentor\Reflection\Types\Integer;

class AcceptFeedbackData
{
    public function __construct(
        public string $title,
        public string $description,
        public string $service_name,
        public DateTime $datetime,
        public int $rating
    ) {}
}
