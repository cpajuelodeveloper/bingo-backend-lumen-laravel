<?php

class BingoTest extends TestCase
{
    /**
     * Return actual call and array of calls.
     *
     * @return void
     */
    public function testCall()
    {
        $response = $this->json('GET', '/bingo/call');
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([ 'call', 'calls' ]);
    }

    public function testNegativeTestcaseForAssertFileExists()
    {
        $this->assertFileExists(
            storage_path('app/') . 'bingo.json',
            "given filename doesn't exists"
        );
    }

    /**
     * Return cardNumber and card structure
     *
     * @return void
     */
    public function testCard()
    {
        $response = $this->json('GET', '/bingo/cards/take');

        $response->assertResponseStatus(200);
        $response->seeJsonStructure([ 'cardNumber', 'card' ]);
        $content = $response->response->original;
        $this->assertCount(5, $content['card']);

    }

    /**
     * Return array [winner, cardNumber, options]
     *
     * @return void
     */
    public function testCheck()
    {
        $response = $this->json('GET', '/bingo/cards/check/1');
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([ 'isWinner', 'cardNumber', 'options' ]);

    }

    /**
     * Return cardNumber and card structure
     *
     * @return void
     */
    public function testCheckAll()
    {
        $response = $this->json('GET', '/bingo/cards/check-all');
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([ 'checkings' => [] ]);

    }

    /**
     * Return cardNumber and card structure
     *
     * @return void
     */
    public function testResetGame()
    {
        $response = $this->json('GET', '/bingo/reset');
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([ 'success', "message" ]);
        $response->receiveJson(["success" => true ]);

    }
}