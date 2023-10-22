<?php

declare(strict_types=1);

namespace App\Tests\Context;

use App\Kernel;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterFeatureScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
// use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Dotenv\Dotenv;

class FeatureContext implements Context
{
    private static Kernel $kernel;

    /**
     * @AfterScenario
     */
    public function after(AfterScenarioScope $scope): void
    {
        $this->cleanUpData();
        // var_dump('after scenario');
    }

    /**
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope): void
    {
    }

    /**
     * @BeforeSuite
     */
    public static function bootstrapSymfony(BeforeSuiteScope $scope): void
    {
        // Load environment variables from .env.test
        $envFilePath = __DIR__.'/../../../.env.dev.local';

        if (file_exists($envFilePath)) {
            (new Dotenv())->loadEnv($envFilePath);
            // var_dump('loaded env file: ');
        }

        $loginPath = getenv('LOGIN_PATH');
        $testPassword = getenv('TEST_PASSWORD');
        // var_dump('$loginPath: '.$loginPath);
        // var_dump('$testPassword: '.$testPassword);

        require_once __DIR__.'/../../../vendor/autoload.php';
        self::$kernel = new Kernel('dev', true);
        self::$kernel->boot();
    }

    /**
     * @BeforeFeature
     */
    public static function setupFeature(BeforeFeatureScope $scope): void
    {
    }

    /**
     * @AfterFeature
     */
    public static function teardownFeature(AfterFeatureScope $scope): void
    {
    }

    private function cleanUpData(): void
    {
        $application = new Application(self::$kernel);
        $application->setAutoExit(false); // Avoids exiting the script

        // Command to run
        $input = new ArrayInput(['command' => 'app:clean-up-database']);

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        // Display command output if needed
        // $commandOutput = $output->fetch();
        // var_dump($commandOutput);
    }
}
