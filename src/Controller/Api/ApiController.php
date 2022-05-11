<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: '')]
    public function index()
    {
        return new JsonResponse([
            'code' => 200,
            'message' => 'Welcome to the ESGI Gaming API !',
        ], 200);
    }

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        try {
            $this->populate = $this->strToFormatedArray($request->get('populate'));
        } catch (\Exception $e) {
            $this->populate = null;
        }

        $this->limit  = (int)$request->query->get('limit') > 0 ? (int)$request->query->get('limit') : null;
        $this->criteria = json_decode($request->query->get('criteria')) ? json_decode($request->query->get('criteria'), true) : [];
        $this->order = json_decode($request->query->get('order')) ? json_decode($request->query->get('order'), true) : [];
        $this->offset = (int)$request->query->get('offset') ? (int)$request->query->get('offset') : 0;
        $this->whitelistCriteria = [];
    }

    public function whitelistCriteriaValidator()
    {
        foreach ($this->criteria as $k => $v) {
            if (!in_array($k, $this->whitelistCriteria)) {
                return false;
            }
        }
        return true;
    }

    public function strToFormatedArray($string)
    {
        $splitArray = array_values(preg_split('/(,|{|})/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE));

        $formatedArray = [];
        $levelSplit = [];
        $parentLevel = 0;

        for ($i = 0; $i < count($splitArray); $i++) {
            if ($i < count($splitArray) - 1 && $splitArray[$i] == '{') {
                $parentLevel++;
            } else if ($i > 0 && $splitArray[$i - 1] == '}') {
                $parentLevel--;
            }
            if ($parentLevel == 0) {
                $levelSplit[] = $i;
            }
        }

        for ($i = 0; $i < count($levelSplit); $i++) {
            if ($i == count($levelSplit) - 1) {
                $formatedArray[] = implode('', array_slice($splitArray, $levelSplit[$i]));
            } else {
                $formatedArray[] = implode('', array_slice($splitArray, $levelSplit[$i], $levelSplit[$i + 1] - $levelSplit[$i]));
            }
        }

        return $this->arrayPopulateRecursive(array_diff($formatedArray, [',']));
    }

    private function arrayPopulateRecursive($value)
    {
        $arr = [];
        if (is_array($value)) {
            foreach ($value as $m) {
                if (preg_match('/({|})/', $m)) {
                    preg_match('/(\w*){(\S*)}$/', $m, $kv);
                    $arr[$kv[1]] = $this->arrayPopulateRecursive($kv[2]);
                } else {
                    $arr[] = $m;
                }
            }
        } else {
            preg_match_all('/(\w*{[\w,]*[\w{,]*[}]*|\w*)/', $value, $matches, PREG_SPLIT_NO_EMPTY);

            foreach (array_filter($matches[0]) as $m) {
                if (preg_match('/({|})/', $m)) {
                    preg_match('/(\w*){(\S*)}$/', $m, $kv);
                    $arr[$kv[1]] = $this->arrayPopulateRecursive($kv[2]);
                } else {
                    $arr[] = $m;
                }
            }
        }
        return $arr;
    }

    public function isAuthorized(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            return true;
        }
        return false;
    }

    public function customErrorResponse($data, $code)
    {
        return new JsonResponse([
            'code' => $code,
            'error' => $data,
        ], $code);
    }


    public function unvalidatedCriteriaResponse()
    {
        return new JsonResponse([
            'code' => 400,
            'message' => 'Invalid criteria.',
            'criteria' => $this->criteria,
            'whitelist' => $this->whitelistCriteria,
        ], 400);
    }

    public function unvalidatedPopulateResponse()
    {
        return new JsonResponse([
            'code' => 400,
            'message' => 'Invalid populate.',
        ], 400);
    }

    public function unAuthorizedResponse()
    {
        return new JsonResponse([
            'code' => 401,
            'message' => 'You are not authorized to access this page.',
        ], 401);
    }

    public function successResponse($data)
    {
        return new JsonResponse([
            'code' => 200,
            'message' => 'Success request.',
            'data' => $data,
        ], 200);
    }
}
