<?php

namespace App\DataFixtures;

use App\Config\StatusEnum;
use App\Entity\Request;
use App\Entity\User;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Фикстура для заявок
 */
class RequestFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $request = new Request();
        $request->setTitle('Старая заявка');
        $request->setText('Текст заявки');
        $request->setCreatedAt((new Carbon())
            ->setTimezone('Europe/Moscow')
            ->subHours(5)->toDateTimeImmutable());
        $request->setUserId(1);
        $request->setStatus(StatusEnum::NEW->value);

        $manager->persist($request);
        $manager->flush();

        $request = new Request();
        $request->setTitle('Еще непросроченная заявка');
        $request->setText('Текст заявки');
        $request->setCreatedAt((new Carbon())
            ->setTimezone('Europe/Moscow')
            ->subMinutes(5)
            ->toDateTimeImmutable());
        $request->setUserId(1);
        $request->setStatus(StatusEnum::NEW->value);

        $manager->persist($request);
        $manager->flush();

        $request = new Request();
        $request->setTitle('Заявка в работе');
        $request->setText('Текст заявки');
        $request->setCreatedAt((new Carbon())
            ->setTimezone('Europe/Moscow')
            ->subMinutes(5)
            ->toDateTimeImmutable());
        $request->setUserId(1);
        $request->setStatus(StatusEnum::WORK_IN_PROGRESS->value);

        $manager->persist($request);
        $manager->flush();
    }
}
