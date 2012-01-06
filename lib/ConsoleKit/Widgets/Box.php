<?php
/**
 * ConsoleKit
 * Copyright (c) 2012 Maxime Bouroumeau-Fuseau
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Maxime Bouroumeau-Fuseau
 * @copyright 2012 (c) Maxime Bouroumeau-Fuseau
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://github.com/maximebf/ConsoleKit
 */

namespace ConsoleKit\Widgets;

use ConsoleKit\TextWriter,
    ConsoleKit\ConsoleException;

class Box extends AbstractWidget
{
    /** @var string */
    protected $text;

    /** @var string */
    protected $lineCharacter;

    /** @var int */
    protected $padding;

    /**
     * @param TextWriter $writer
     * @param string $text
     */
    public function __construct(TextWriter $writer = null, $text = '', $lineCharacter = '*', $padding = 2)
    {
        $this->textWriter = $writer;
        $this->text = $text;
        $this->lineCharacter = $lineCharacter;
        $this->padding = $padding;
    }

    /**
     * @param string text
     * @return Box
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string lineCharacter
     * @return Box
     */
    public function setLineCharacter($lineCharacter)
    {
        $this->lineCharacter = $lineCharacter;
        return $this;
    }

    /**
     * @return string
     */
    public function getLineCharacter()
    {
        return $this->lineCharacter;
    }

    /**
     * @param int padding
     * @return Box
     */
    public function setPadding($padding)
    {
        $this->padding = $padding;
        return $this;
    }

    /**
     * @return int
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * @return string
     */
    public function render()
    {
        $lines = explode("\n", $this->text);
        $maxWidth = 0;
        foreach ($lines as $line) {
            if (strlen($line) > $maxWidth) {
                $maxWidth = strlen($line);
            }
        }

        $maxWidth += $this->padding * 2 + 2;
        $c = $this->lineCharacter;
        $output = str_repeat($c, $maxWidth) . "\n";
        foreach ($lines as $line) {
            $delta = $maxWidth - (strlen($line) + 2 + $this->padding * 2);
            $output .= $c . str_repeat(' ', $this->padding) . $line
                     . str_repeat(' ', $delta + $this->padding) . $c . "\n";
        }
        $output .= str_repeat($c, $maxWidth);
        return $output;
    }

    public function write()
    {
        if ($this->textWriter === null) {
            throw new ConsoleException('No TextWriter object specified');
        }
        $this->textWriter->write($this->render());
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }
}