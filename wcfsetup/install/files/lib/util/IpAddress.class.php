<?php

namespace wcf\util;

/**
 * Represents an IP address.
 *
 * @author  Tim Duesterhus
 * @copyright   2001-2021 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package WoltLabSuite\Core\Util
 * @since       5.4
 */
final class IpAddress
{
    /**
     * @var string
     */
    private $ipAddress;

    public function __construct(string $ipAddress)
    {
        if (\filter_var($ipAddress, \FILTER_VALIDATE_IP) === false) {
            throw new \InvalidArgumentException(\sprintf(
                "The given IP address '%s' is not a valid IP address.",
                $ipAddress
            ));
        }

        $this->ipAddress = $ipAddress;
    }

    /**
     * Returns the IP address in IPv6 form. An IPv4 address will be returned as
     * an IPv4-mapped address.
     */
    public function asV6(): self
    {
        return new self(UserUtil::convertIPv4To6($this->ipAddress));
    }

    /**
     * Returns the IP address in IPv4 form. Null will be returned if the IP address
     * is neither an IPv4 address, nor an IPv4-mapped address.
     */
    public function asV4(): ?self
    {
        // Return an IPv4 as-is.
        if (\filter_var($this->ipAddress, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4) !== false) {
            return $this;
        }

        // Check for an IPv4-mapped address.
        $ip = $this->ipAddress;
        if (\substr($ip, 0, 7) == '::ffff:') {
            $ip = \substr($ip, 7);
            if (\preg_match('~^([a-f0-9]{1,4}):([a-f0-9]{1,4})$~', $ip, $matches)) {
                $ip = [
                    \base_convert($matches[1], 16, 10),
                    \base_convert($matches[2], 16, 10),
                ];

                $ipParts = [];
                $tmp = $ip[0] % 256;
                $ipParts[] = ($ip[0] - $tmp) / 256;
                $ipParts[] = $tmp;
                $tmp = $ip[1] % 256;
                $ipParts[] = ($ip[1] - $tmp) / 256;
                $ipParts[] = $tmp;

                return new self(\implode('.', $ipParts));
            }

            return new self($ip);
        }

        return null;
    }

    /**
     * Returns a new IP address with the last $maskX bits masked off.
     */
    public function toMasked(int $mask4, int $mask6): self
    {
        if ($mask4 < 0 || $mask4 > 32) {
            throw new \InvalidArgumentException('Given $mask4 is not in the interval [0, 32].');
        }
        if ($mask6 < 0 || $mask6 > 128) {
            throw new \InvalidArgumentException('Given $mask6 is not in the interval [0, 128].');
        }

        $ipAddress = $this->asV4();

        if ($ipAddress === null) {
            $ipAddress = $this->asV6();
            $maskBits = $mask6;
            $bytes = 16;
        } else {
            $maskBits = $mask4;
            $bytes = 4;
        }

        $mask = '';
        for ($i = 0; $i < $bytes; $i++, $maskBits -= 8) {
            $mask .= \chr(0xff << (8 - \min(8, $maskBits)));
        }

        return new self(\inet_ntop(\inet_pton((string)$ipAddress) & $mask));
    }

    /**
     * @see IpAddress::getIpAddress()
     */
    public function __toString(): string
    {
        return $this->getIpAddress();
    }

    /**
     * Returns the raw IP address that was used to construct this instance.
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}
