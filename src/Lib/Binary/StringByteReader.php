<?php

/**
 * This file is part of the sj-i/php-profiler package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpProfiler\Lib\Binary;

/**
 * Class StringByteReader
 * @package PhpProfiler\Lib\Binary
 */
final class StringByteReader implements ByteReaderInterface
{
    use ByteReaderDisableWriteAccessTrait;

    private string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->source[$offset]);
    }

    public function offsetGet($offset): string
    {
        return $this->source[$offset];
    }

    public function createSliceAsString(int $offset, int $size): string
    {
        return substr($this->source, $offset, $size);
    }
}
