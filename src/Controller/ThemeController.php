<?php

namespace App\Controller;

use App\Controller\Service\InterpretationManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ThemeController
 * @package App\Controller
 */
class ThemeController extends InterpretationManager
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        // TODO: remove redirect when ready for com (+ links title info)
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->getSession()->createAlert(
                "Partie Thème très prochainement disponible!", "red"
            );

            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {

            return $this->render("front/theme/theme.twig", [
                "numbers" => $this->numbers
            ]);
        }

        return $this->render("front/theme/theme.twig");
    }
}
