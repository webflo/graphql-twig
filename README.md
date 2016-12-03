# Installation

Install the library using composer:

```
composer require dawehner/graphql-twig
```

## Usage

In your twig environment add a twig extension:

```
$loader = new \Twig_Loader_Filesystem('templates');
$twig = new \Twig_Environment($loader, [
]);
$twig->addExtension(new GraphqlTwigExtension($processor));
```
