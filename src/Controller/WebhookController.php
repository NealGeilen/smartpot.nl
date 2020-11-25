<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

class WebhookController extends AbstractController
{
    /**
     * @Route("/webhook/update", name="webhook_cache_clear")
     */
    public function update(Request $request,KernelInterface $kernel): Response
    {
        if ($request->query->get("Key", 0) === "3740823740928374"){
            $Response = [];
            $Response[] = shell_exec("git pull");
            $Response[] = $this->do_command($kernel, "doctrine:migrations:migrate", ["--no-interaction"]);
            $Response[] = $this->do_command($kernel,"cache:clear");
            return (new JsonResponse($Response))->setEncodingOptions(JSON_PRETTY_PRINT);
        }
        return $this->redirect("/");
    }

    private function do_command($kernel, $command, $options = [])
    {
        $env = $kernel->getEnvironment();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array_merge(array(
            'command' => $command,
            '--env' => $env
        ), $options));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

        return $content;
    }
}
