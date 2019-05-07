<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestDecoderListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        if ($event->isMasterRequest() && !empty($content) && $this->isJsonRequest($request)) {
            $this->decodeJsonBody($request);
        }
    }

    protected function isJsonRequest(Request $request)
    {
        return 'json' === $request->getContentType();
    }

    /**
     * @throws BadRequestHttpException If the request body contains invalid JSON
     */
    protected function decodeJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // Throw an exception if the JSON is invalid
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('Invalid JSON request received.');
        }

        // If we have data decoded put it into the request
        if (null !== $data) {
            $request->request->replace($data);
        }
    }
}
