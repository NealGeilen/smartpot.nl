<?php

namespace App\Security;

use App\Entity\Device;
use App\Entity\Pot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserApiAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        $string = file_get_contents('php://input');
        $aResponse = json_decode($string, true);
        return $request->headers->has('X-AUTH-TOKEN') || (isset($aResponse["username"]) && isset($aResponse["password"]));
    }

    public function getCredentials(Request $request)
    {
        $string = file_get_contents('php://input');
        $aResponse = json_decode($string, true);
        $credentials = [
            'TOKEN' => $request->headers->get('X-AUTH-TOKEN', null),
            'USERNAME' => $aResponse["username"],
            'PASSWORD' => $aResponse["password"]
        ];
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $Device = $this->entityManager->getRepository(Device::class)->findOneBy(["Token"=> $credentials["TOKEN"]]);

        if ($Device instanceof Device){
            return $Device->getUser();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(["username" => $credentials["USERNAME"]]);
        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('User could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (isset($credentials["PASSWORD"])){
            return $this->passwordEncoder->isPasswordValid($user, $credentials["PASSWORD"]);
        }
        return true;

    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return null;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {

        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, 401);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
