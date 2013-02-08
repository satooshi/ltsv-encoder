<?php

/**
 * Simple LTSV parser.
 *
 * @author KITAMURA Satoshi
 */
class LTSV
{
    /**
     * Parse LTSV line.
     *
     * @param string $line
     * @return array
     */
    public function parseLine($line)
    {
        $fields = explode("\t", trim($line));

        $array = array();

        foreach ($fields as $field) {
            if (false !== stripos($field, ':')) {
                $labelValue = explode(':', $field);

                if (count($labelValue) === 2) {
                    $array[$labelValue[0]] = $labelValue[1];
                }
            }
        }

        return $array;
    }

    /**
     * Parse LTSV file.
     *
     * @param string $path LTSV file path.
     * @return array
     * @throws \RuntimeException
     */
    public function parseFile($path)
    {
        if (is_file($path) && is_readable($path)) {
            $handle = fopen($path, 'r');

            if (false !== $handle) {
                $content = array();

                while (false !== $line = fgets($handle)) {
                    $parsed = $this->parseLine($line);

                    if (!empty($parsed)) {
                        $content[] = $parsed;
                    }
                }

                fclose($handle);

                return $content;
            }
        }

        throw new \RuntimeException("Failed to read file for read : $path.");
    }

    /**
     * Dump LTSV line.
     *
     * @param array $data
     * @return string
     */
    public function asLtsvLine(array $data)
    {
        $content = array();

        foreach ($data as $key => $value) {
            $content[] = sprintf('%s:%s', $key, $value);
        }

        return implode("\t", $content);
    }

    /**
     * Dump LTSV lines.
     *
     * @param array $data
     * @return string
     */
    public function asLtsvLines(array $data)
    {
        $content = array();

        foreach ($data as $lineData) {
            $content[] = $this->asLtsvLine($lineData);
        }

        return implode("\n", $content);
    }
}
