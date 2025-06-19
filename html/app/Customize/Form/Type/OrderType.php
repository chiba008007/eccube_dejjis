<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Form\Type;

use Eccube\Form\Type\Shopping\OrderType as BaseOrderType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Eccube\Repository\TaxRuleRepository;

class OrderType extends BaseOrderType
{
    private $requestStack;
    private $TaxRule;
    public function __construct(TaxRuleRepository $TaxRule, RequestStack $requestStack)
    {
        $this->TaxRule = $TaxRule;
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            $request = $this->requestStack->getCurrentRequest();
            $sessionId = $request?->getSession()?->get('punchout_session_id');

            if ($sessionId) {
                // PunchOutのセッションがある場合、以下の入力を「必須でなくす」
                $fields = [
                    'order_email',
                    'order_tel',
                    'order_zip01',
                    'order_zip02',
                    'order_addr01',
                    'order_addr02',
                ];

                foreach ($fields as $field) {
                    if ($form->has($field)) {
                        $form->add($field, null, [
                            'required' => false,
                        ]);
                    }
                }
            }
        });
    }
}
