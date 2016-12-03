<?php

namespace dawehner\GraphqlTwig;

use Youshido\GraphQL\Execution\Processor;

/**
 * Provides a twig extension which allows you to execute gql queries.
 */
class GraphqlTwigExtension extends \Twig_Extension {

    /**
     * The GraphQL processor.
     *
     * @var \Youshido\GraphQL\Execution\Processor
     */
    protected $processor;

    /**
     * Creates a new GraphqlTwigExtension instance.
     *
     * @param \Youshido\GraphQL\Execution\Processor $processor
     *   The graphql processor.
     */
    public function __construct(Processor $processor) {
        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('gql', [$this, 'gqlFunction']),
        ];
    }

  /**
   * Returns the executed gql query.
   *
   * @param string $query
   *   The GQL query.
   */
    public function gqlFunction($query)
    {
        return $this->processor->processPayload($query)->getResponseData()['data'];
    }

}
