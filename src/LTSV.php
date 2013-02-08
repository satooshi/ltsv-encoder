<?php

class LTSV
{
    public function parseLine($line)
    {
        $fields = explode("\t", trim($line));

        $array = array();

        foreach ($fields as $field) {
            if (false !== stripos($field, ':')) {
                $keyValue = explode(":", $field);

                if (count($keyValue) === 2) {
                    $array[$keyValue[0]] = $keyValue[1];
                }
            }
        }

        return $array;
    }

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

    public function asLtsvLine($lineData)
    {
        $content = array();

        foreach ($lineData as $key => $value) {
            $content[] = sprintf('%s:%s', $key, $value);
        }

        return implode("\t", $content);
    }

    public function asLtsvLines($data)
    {
        $content = array();

        foreach ($data as $lineData) {
            $content[] = $this->asLtsvLine($lineData);
        }

        return implode("\n", $content);
    }
}
