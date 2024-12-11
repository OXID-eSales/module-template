<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\ProductVote\Dao;

use OxidEsales\EshopCommunity\Tests\ContainerTrait;
use OxidEsales\ModuleTemplate\ProductVote\Dao\ProductVoteDaoInterface;
use OxidEsales\ModuleTemplate\ProductVote\Dao\VoteResultDao;
use OxidEsales\ModuleTemplate\ProductVote\Dao\VoteResultDaoInterface;
use OxidEsales\ModuleTemplate\ProductVote\DataObject\ProductVote;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(VoteResultDao::class)]
final class ResultDaoTest extends IntegrationTestCase
{
    use ContainerTrait;

    private const TEST_PRODUCT_ID = '_testproduct';

    protected function tearDown(): void
    {
        $this->cleanUpVotes();

        parent::tearDown();
    }

    #[Test]
    public function calculateNoVotes(): void
    {
        /** @var VoteResultDaoInterface $sut */
        $sut = $this->get(VoteResultDaoInterface::class);
        $result = $sut->getProductVoteResult(self::TEST_PRODUCT_ID);

        $this->assertEquals(self::TEST_PRODUCT_ID, $result->getProductId());
        $this->assertEquals(0, $result->getVoteUp());
        $this->assertEquals(0, $result->getVoteDown());
    }

    #[Test]
    public function calculateOneVoteResult(): void
    {
        $this->addProductVote(true, 'user_1');

        $sut = $this->get(VoteResultDaoInterface::class);
        $result = $sut->getProductVoteResult(self::TEST_PRODUCT_ID);
        $this->assertEquals(self::TEST_PRODUCT_ID, $result->getProductId());
        $this->assertEquals(1, $result->getVoteUp());
        $this->assertEquals(0, $result->getVoteDown());
    }

    #[Test]
    public function calculateManyVotesResult(): void
    {
        $this->addProductVote(true, 'user_1'); // 1/0
        $this->addProductVote(false, 'user_2');// 1/1
        $this->addProductVote(false, 'user_3');// 1/2
        $this->addProductVote(false, 'user_4');// 1/3
        $this->addProductVote(true, 'user_5'); // 2/3
        $this->addProductVote(true, 'user_6'); // 3/3
        $this->addProductVote(true, 'user_7'); // 4/3

        $sut = $this->get(VoteResultDaoInterface::class);
        $result = $sut->getProductVoteResult(self::TEST_PRODUCT_ID);
        $this->assertEquals(self::TEST_PRODUCT_ID, $result->getProductId());
        $this->assertEquals(4, $result->getVoteUp());
        $this->assertEquals(3, $result->getVoteDown());
    }

    private function addProductVote(bool $isVoteUp, string $userId): void
    {
        $vote = new ProductVote(self::TEST_PRODUCT_ID, $userId, $isVoteUp);

        /** @var ProductVoteDaoInterface $productVoteDao */
        $productVoteDao = $this->get(ProductVoteDaoInterface::class);
        $productVoteDao->setProductVote($vote);
    }
}
