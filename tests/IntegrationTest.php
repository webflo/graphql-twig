<?php

namespace Tests;

use dawehner\GraphqlTwig\GraphqlTwigExtension;
use Tests\Fixture\PostType;
use Youshido\GraphQL\Execution\Processor;
use Youshido\GraphQL\Schema\Schema;
use Youshido\GraphQL\Type\Object\ObjectType;

require_once __DIR__ . '/Fixture/PostType.php';

class IntegrationTest extends \PHPUnit_Framework_TestCase {

    public function testTwigIntegration()
    {
        $rootQueryType = new ObjectType([
          'name' => 'RootQueryType',
          'fields' => [
            'latestPost' => [
              'type'    => new PostType(),
              'resolve' => function ($source, $args, $info)
              {
                return [
                  "title"   => "New approach in API has been revealed",
                  "summary" => "In two words - GraphQL Rocks!",
                ];
              }
            ]
          ]
        ]);

        $processor = new Processor(new Schema([
          'query' => $rootQueryType
        ]));

        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader, [
          'cache' => '/tmp',
          'debug' => true,
        ]);
        $twig->addExtension(new GraphqlTwigExtension($processor));
        $twig->addExtension(new \Twig_Extension_Debug());

        $template = <<<TWIG
{% set data = gql("
{ latestPost { title, summary } }
")
%}

{{ data.latestPost.title }}

TWIG;

        $output = $twig->render($template, $processor->getResponseData());

        $expected = <<<HTML

New approach in API has been revealed

HTML;
        $this->assertEquals($expected, $output);
    }

}
