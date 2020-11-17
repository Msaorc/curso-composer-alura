<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     *
     * @var ClientInterface
     */
    private $httpClient;

    /**
     *
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    /**
     * Função responsavel por buscar os cursos na alura
     *
     * @param string $url
     * @return array
     */
    public function buscar(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);
        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);

        $elements = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elements as $curso) {
            $cursos[] = $curso->textContent . PHP_EOL;
        }

        return $cursos;
    }
}
