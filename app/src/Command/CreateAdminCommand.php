<?php

namespace App\Command;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create an administrator',
)]
class CreateAdminCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('app:create-admin');

        $this->entityManager = $entityManager;
    }

    
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password')
            ->addArgument('first_name', InputArgument::OPTIONAL, 'First Name')
            ->addArgument('last_name', InputArgument::OPTIONAL, 'Last Name')
            ->addArgument('username', InputArgument::OPTIONAL, 'Username')
            ->addArgument('gender', InputArgument::OPTIONAL, 'Username')
            ->addArgument('birthday', InputArgument::OPTIONAL, 'Username')
            ->addArgument('country', InputArgument::OPTIONAL, 'Country')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Type your email: ');
            $email = $helper->ask($input, $output, $question);
        }

        $plainPassword = $input->getArgument('password');
        if (!$plainPassword) {
            $question = new Question('Type your password : ');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $plainPassword = $helper->ask($input, $output, $question);
        }

        $firstName = $input->getArgument('first_name');
        if (!$firstName) {
            $question = new Question('type your First Name : ');
            $firstName = $helper->ask($input, $output, $question);
        }

        $lastName = $input->getArgument('last_name');
        if (!$lastName) {
            $question = new Question('type your Last Name : ');
            $lastName = $helper->ask($input, $output, $question);
        }

        $username = $input->getArgument('username');
        if (!$username) {
            $question = new Question('type your Username : ');
            $username = $helper->ask($input, $output, $question);
        }

        $gender = $input->getArgument('gender');
        if (!$gender) {
            $question = new Question('type your Gender (Options: male, female and other) : ');
            $gender = $helper->ask($input, $output, $question);
        }

        $birthday = $input->getArgument('birthday');
        if (!$birthday) {
            $question = new Question('type your Birthday (mm-dd-YYYY) : ');
            $birthday = $helper->ask($input, $output, $question);
        }

        $country = $input->getArgument('country');
        if (!$country) {
            $question = new Question('type your Country (Ex: TN, DZ) : ');
            $country = $helper->ask($input, $output, $question);
        }

        $user = (new User())
        ->setFirstName($firstName)
        ->setLastName($lastName)
        ->setUsername($username)
        ->setNickname($username)
        ->setEmail($email)
        ->setPlainPassword($plainPassword)
        ->setGender($gender)
        ->setBirthday(DateTimeImmutable::createFromFormat('m-d-Y', $birthday))
        ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ->setCountry($country);

        $existingEmail = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($existingEmail) {
            $io->warning('This email is already taken.');
            return Command::FAILURE;
        }
        else if ($existingUser) {
            $io->warning('This username is already taken.');
            return Command::FAILURE;
        } else {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('New admin have been created!');
            return Command::SUCCESS;
        }
    }
}
