<?php

namespace App\Test\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/image/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Image::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Image index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'image[url]' => 'Testing',
            'image[altText]' => 'Testing',
            'image[product]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Image();
        $fixture->setUrl('My Title');
        $fixture->setAltText('My Title');
        $fixture->setProduct('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Image');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Image();
        $fixture->setUrl('Value');
        $fixture->setAltText('Value');
        $fixture->setProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'image[url]' => 'Something New',
            'image[altText]' => 'Something New',
            'image[product]' => 'Something New',
        ]);

        self::assertResponseRedirects('/image/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getUrl());
        self::assertSame('Something New', $fixture[0]->getAltText());
        self::assertSame('Something New', $fixture[0]->getProduct());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Image();
        $fixture->setUrl('Value');
        $fixture->setAltText('Value');
        $fixture->setProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/image/');
        self::assertSame(0, $this->repository->count([]));
    }
}