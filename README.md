# Installation

Install the library using composer:

```
composer require dawehner/graphql-twig
```

## Usage

In your twig environment add a twig extension:

```
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
```
