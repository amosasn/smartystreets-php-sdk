<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/us_street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\Batch;

$lookupExample = new USStreetLookupsWithMatchStrategyExamples();
$lookupExample->run();

class USStreetLookupsWithMatchStrategyExamples {

    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildUsStreetApiClient();
        $batch = new Batch();

        $addressWithStrictStrategy = new Lookup();
        $addressWithStrictStrategy->setStreet("691 W 1150 S");
        $addressWithStrictStrategy->setCity("provo");
        $addressWithStrictStrategy->setState("utah");
        $addressWithStrictStrategy->setMatchStrategy(Lookup::STRICT);

        $addressWithRangeStrategy = new Lookup();
        $addressWithRangeStrategy->setStreet("693 W 1150 S");
        $addressWithRangeStrategy->setCity("provo");
        $addressWithRangeStrategy->setState("utah");
        $addressWithRangeStrategy->setMatchStrategy(Lookup::RANGE);

        $addressWithInvalidStrategy = new Lookup();
        $addressWithInvalidStrategy->setStreet("9999 W 1150 S");
        $addressWithInvalidStrategy->setCity("provo");
        $addressWithInvalidStrategy->setState("utah");
        $addressWithInvalidStrategy->setMatchStrategy(Lookup::INVALID);

        try {
            $batch->add($addressWithStrictStrategy);
            $batch->add($addressWithRangeStrategy);
            $batch->add($addressWithInvalidStrategy);

            $client->sendBatch($batch);
            $this->displayResults($batch);
        }
        catch (BatchFullException $ex) {
            echo("Oops! Batch was already full.");
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Batch $batch) {
        $lookups = $batch->getAllLookups();

        for($i = 0; $i < $batch->size(); $i++) {
            $candidates = $lookups[$i]->getResult();

            if (empty($candidates)) {
                echo("\nAddress " . $i . " is invalid.\n");
                continue;
            }

            echo("\nAddress " . $i . " is valid. (There is at least one candidate)");

            foreach ($candidates as $candidate) {
                $components = $candidate->getComponents();
                $metadata = $candidate->getMetadata();

                echo("\n\nCandidate " . $candidate->getCandidateIndex() . " ");
                echo("with " . $lookups[$i]->getMatchStrategy() . " strategy");
                echo("\nDelivery line 1: " . $candidate->getDeliveryLine1());
                echo("\nLast line:       " . $candidate->getLastLine());
                echo("\nZIP Code:        " . $components->getZipCode() . "-" . $components->getPlus4Code());
                echo("\nCounty:          " . $metadata->getCountyName());
                echo("\nLatitude:        " . $metadata->getLatitude());
                echo("\nLongitude:       " . $metadata->getLongitude());
            }
            echo("\n***********************************\n");
        }
        echo("\n");
    }
}