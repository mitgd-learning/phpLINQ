<?php

/**********************************************************************************************************************
 * phpLINQ (https://github.com/mkloubert/phpLINQ)                                                                     *
 *                                                                                                                    *
 * Copyright (c) 2015, Marcel Joachim Kloubert <marcel.kloubert@gmx.net>                                              *
 * All rights reserved.                                                                                               *
 *                                                                                                                    *
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the   *
 * following conditions are met:                                                                                      *
 *                                                                                                                    *
 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the          *
 *    following disclaimer.                                                                                           *
 *                                                                                                                    *
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the       *
 *    following disclaimer in the documentation and/or other materials provided with the distribution.                *
 *                                                                                                                    *
 * 3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote    *
 *    products derived from this software without specific prior written permission.                                  *
 *                                                                                                                    *
 *                                                                                                                    *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, *
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE  *
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, *
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,  *
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE   *
 * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                                           *
 *                                                                                                                    *
 **********************************************************************************************************************/

use \System\Collections\IEnumerable;


function thenSelector1FuncForTest1($x) : int {
    return strlen($x);
}

class ThenSelector1ForTest1Class {
    public function __invoke($x) {
        return thenSelector1FuncForTest1($x);
    }
}


/**
 * @see \System\Linq\IOrderedEnumerable::then()
 *
 * @author Marcel Joachim Kloubert <marcel.kloubert@gmx.net>
 */
class ThenTests extends TestCaseBase {
    /**
     * Creates selectors for ThenByTests::test1() method.
     *
     * @return array The selectors.
     */
    protected function createSelectorsForTest1() : array {
        return [
            [
                function($x) { return thenSelector1FuncForTest1($x); },
            ],
            [
                array($this, 'selector1Method1'),
            ],
            [
                array(static::class, 'selector1Method2'),
            ],
            [
                new ThenSelector1ForTest1Class(),
            ],
            [
                'thenSelector1FuncForTest1',
            ],
            [
                '\thenSelector1FuncForTest1',
            ],
            [
                '$x => thenSelector1FuncForTest1($x)',
            ],
            [
                '($x) => thenSelector1FuncForTest1($x)',
            ],
            [
                '$x => return thenSelector1FuncForTest1($x);',
            ],
            [
                '($x) => return thenSelector1FuncForTest1($x);',
            ],
            [
                '($x) => { return thenSelector1FuncForTest1($x); }',
            ],
            [
                '($x) => {
$y = thenSelector1FuncForTest1($x);
return $y;
}',
            ],
            [
                '$x => \thenSelector1FuncForTest1($x)',
            ],
            [
                '($x) => \thenSelector1FuncForTest1($x)',
            ],
            [
                '$x => return \thenSelector1FuncForTest1($x);',
            ],
            [
                '($x) => return \thenSelector1FuncForTest1($x);',
            ],
            [
                '($x) => { return \thenSelector1FuncForTest1($x); }',
            ],
            [
                '($x) => {
$y = \thenSelector1FuncForTest1($x);
return $y;
}',
            ],
        ];
    }

    public function test1() {
        foreach ($this->createSelectorsForTest1() as $selectors) {
            $values = [
                "grape",
                "passionfruit",
                "banana",
                "mango",
                "orange",
                "raspberry",
                "apple",
                "blueberry",
            ];

            foreach (static::sequenceListFromArray($values) as $seq) {
                /* @var IEnumerable $seq */

                $items = static::sequenceToArray($seq->orderBy($selectors[0])
                                                     ->then(), false);

                $this->assertEquals(8, count($items));

                $this->assertSame('apple', $items[0]);
                $this->assertSame('grape', $items[1]);
                $this->assertSame('mango', $items[2]);
                $this->assertSame('banana', $items[3]);
                $this->assertSame('orange', $items[4]);
                $this->assertSame('blueberry', $items[5]);
                $this->assertSame('raspberry', $items[6]);
                $this->assertSame('passionfruit', $items[7]);
            }
        }
    }

    public function selector1Method1($x) {
        return thenSelector1FuncForTest1($x);
    }

    public static function selector1Method2($x) {
        return thenSelector1FuncForTest1($x);
    }
}
